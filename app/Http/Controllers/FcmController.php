<?php

namespace App\Http\Controllers;

use Throwable;
use App\Services\FcmService;
use Illuminate\Http\Request;
use App\Http\Responses\Response;

class FcmController extends Controller
{
     protected FcmService $service;

    public function __construct(FcmService $service)
    {
        $this->service = $service;
    }

    /**
     * إرسال إشعار لجهاز واحد
     */
    public function sendNotification(Request $request)
    {
        $data = [];
        try {
            $deviceToken = $request->input('device_token');
            $title = $request->input('title');
            $body = $request->input('body');
            $extraData = $request->input('data', []);

            $success = $this->service->sendNotification($deviceToken, $title, $body, $extraData);

            return $success
                ? Response::Success([], 'Notification sent successfully', 200)
                : Response::Error([], 'Failed to send notification');
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }

    /**
     * إرسال إشعار لجميع المستخدمين
     */
    public function sendNotificationToAll(Request $request)
    {
        $data = [];
        try {
            $title = $request->input('title');
            $body = $request->input('body');
            $extraData = $request->input('data', []);

            $this->service->sendNotificationToAll($title, $body, $extraData);

            return Response::Success([], 'Notifications sent to all users', 200);
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }

    /**
     * استرجاع كل الإشعارات للمستخدم الحالي
     */
    public function index()
    {
        $data = [];
        try {
            $data = $this->service->index();
            return Response::Success($data['notifications'], $data['message'], $data['code']);
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }

    /**
     * استرجاع الإشعارات المقروءة
     */
    public function readIndex()
    {
        $data = [];
        try {
            $data = $this->service->readIndex();
            return Response::Success($data['notifications'], $data['message'], $data['code']);
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }

    /**
     * استرجاع الإشعارات غير المقروءة
     */
    public function unreadIndex()
    {
        $data = [];
        try {
            $data = $this->service->unreadIndex();
            return Response::Success($data['notifications'], $data['message'], $data['code']);
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }

    /**
     * عدد الإشعارات غير المقروءة
     */
    public function unreadCount()
    {
        $data = [];
        try {
            $count = $this->service->getUnreadCount();
            return Response::Success(['unread_count' => $count], 'Unread notifications count', 200);
        } catch (Throwable $th) {
            return Response::Error($data, $th->getMessage());
        }
    }
}
