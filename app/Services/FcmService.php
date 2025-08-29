<?php

namespace App\Services;

use App\Http\Responses\Response;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification(?string $deviceToken, string $title, string $body, array $data = []): bool
    {
        try {

            if (empty($deviceToken)) {
                Log::warning('FCM: device token is empty/null, skipping send.');
                return false;
            }

//            // 2) FCM data لازم قيمها تكون strings
//            $payload = [];
//            foreach ($data as $k => $v) {
//                $payload[$k] = is_scalar($v) ? (string) $v : json_encode($v);
//            }


            $notification = Notification::create($title, $body);

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
}
