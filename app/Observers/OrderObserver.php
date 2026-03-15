<?php

namespace App\Observers;

use App\Events\OrderUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function created(Order $order)
    {
        Log::info('Order created:', ['orderID' => $order->id, 'customerID' => $order->customerID]);
    }

    public function updated(Order $order)
    {
        Log::info('Order updated:', ['orderID' => $order->id, 'status' => $order->status]);

        if ($order->status === 'paid') {
            event(new OrderUpdated($order));
        }
    }

    public function deleted(Order $order)
    {
        Log::info('Order deleted:', ['orderID' => $order->id]);
    }
}
