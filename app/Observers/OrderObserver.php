<?php

namespace App\Observers;

use App\Events\OrderUpdated;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Http;

class OrderObserver
{
    public function created(Order $order)
    {
        // Log when a new order is created
        Log::info('Order created:', ['orderID' => $order->id, 'customerID' => $order->customerID]);
    }

    public function updated(Order $order)
    {
        // Log when an order is updated
        Log::info('Order updated:', ['orderID' => $order->id, 'status' => $order->status]);

        if ($order->status === 'paid') {
            event(new OrderUpdated($order));
        }
    }

    public function deleted(Order $order)
    {
        // Log when an order is deleted
        Log::info('Order deleted:', ['orderID' => $order->id]);
    }
}
