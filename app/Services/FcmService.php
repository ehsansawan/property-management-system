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

    public function sendNotification($deviceToken, $title, $body, array $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::new()
            ->toToken($deviceToken)
            ->withNotification($notification)
            ->withData($data);

        try {
            return $this->messaging->send($message);
        }
        catch (MessagingException $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            return Response::error('Failed to send notification: ' ,$e->getMessage(),500);
        }
        catch (FirebaseException $e) {
            Log::error('Firebase error: ' . $e->getMessage());
            return Response::error('Firebase error: '  ,$e->getMessage(),500);
        }

    }
}
