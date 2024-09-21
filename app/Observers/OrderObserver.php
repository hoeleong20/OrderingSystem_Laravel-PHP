<?php
namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

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
        
        // Check if order is completed, update related cart items
        if ($order->status === 'completed') {
            $order->cartItems()->update(['status' => 'completed']);
        }
    }

    public function deleted(Order $order)
    {
        // Log when an order is deleted
        Log::info('Order deleted:', ['orderID' => $order->id]);
        
        // Remove all related cart items
        $order->cartItems()->delete();
    }
}
