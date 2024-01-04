<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Midtrans\CallbackService;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function sendNotificationToUser($userId, $message)
    {


        $user = User::find($userId);
        $token = $user->fcm_token;

        $messaging = app('firebase.messaging');
        $notification = Notification::create('Order Dibayar', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }

    public function receive()
    {
        $callback = new CallbackService;

        // if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 2,
                ]);
            }

            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 3,
                ]);
            }

            if ($callback->isCancelled()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 4,
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        // } else {
        //     return response()
        //         ->json([
        //             'error' => true,
        //             'message' => 'Signature key not verified',
        //         ], 403);
        // }
    }
}
