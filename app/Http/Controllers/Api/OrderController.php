<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Midtrans\CreatePaymentUrlService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function Order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'seller_id' => $request->seller_id,
            'number' => time(),
            'total_price' => $request->total_price,
            'payment_status'=> 1,
            'delivery_addres' => $request->delivery_addres
        ]);
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }

        $midtrans = new CreatePaymentUrlService();
        $paymentUrl = $midtrans->getPaymentUrlService($order->load('user','orderItem'));
        // dd($paymentUrl);
        $order->update([
            'payment_url' => $paymentUrl
        ]);


        return response()->json([
            'data' => $order
        ]);
    }
}
