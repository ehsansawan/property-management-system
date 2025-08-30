<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use App\Http\Responses\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification(?string $deviceToken, string $title, string $body, array $data = [], $ad_id): bool
    {
        try {

            if (empty($deviceToken)) {
                Log::warning('FCM: device token is empty/null, skipping send.');
                return false;
            }
            // // 2) FCM data لازم قيمها تكون strings
            // $payload = [];
            // foreach ($data as $k => $v) {
            //     $payload[$k] = is_scalar($v) ? (string) $v : json_encode($v);
            // }

            $user = User::where('device_token', $deviceToken)->first();

            if ($user) {
                $userId = $user->id;
            }

            Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'body' => $body,
                'type' => 'ad',
                'is_read' => false,
                'ad_id' => $ad_id,
            ]);

            $notification = \Kreait\Firebase\Messaging\Notification::create($title, $body);


            $message = CloudMessage::new()
                ->toToken($deviceToken)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (MessagingException|FirebaseException|\Throwable $e) {
            Log::error('FCM send failed: '.$e->getMessage());
            return false;
        }
    }

    public function getUnreadCount(): int
    {
        return Notification::query()->where('user_id', Auth::guard('api')->user()->id)
            ->where('is_read', false)
            ->count();
    }

    public function index($request)
    {
         // استرجاع الإشعارات الخاصة بالمستخدم الحالي
        $notifications = Notification::query()->where('user_id',Auth::guard('api')->user()->id)
                        ->paginate($request->query('num')??null);

         // تحديث حالة الإشعارات إلى "تمت القراءة
        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }

        $message = 'get notifications successfully';
        $code = 200;
        return ['notifications' => $notifications, 'message' => $message, 'code' => $code];
    }

    public function readIndex($request)
    {
        $notifications = Notification::query()->where('user_id',Auth::guard('api')->user()->id)->where('is_read',true)
                        ->paginate($request->query('num')??null);

        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }
        $message = 'get readed notifications successfully';
        $code = 200;
        return ['notifications' => $notifications, 'message' => $message, 'code' => $code];
    }

    public function unreadIndex($request)
    {
        $notifications = Notification::query()->where('user_id',Auth::guard('api')->user()->id)->where('is_read',false)
                        ->paginate($request->query('num')??null);

        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }
        $message = 'get unreaded notifications successfully';
        $code = 200;
        return ['notifications' => $notifications, 'message' => $message, 'code' => $code];
    }

    public function sendNotificationToAll(string $title, string $body, array $data = [], $ad_id): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $this->sendNotification($user->device_token, $title, $body, $data, $ad_id);
        }
    }
}
