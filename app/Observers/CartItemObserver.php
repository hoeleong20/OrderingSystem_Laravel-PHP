<?php

namespace App\Observers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Log;

class CartItemObserver
{
    public function created(CartItem $cartItem)
    {
        // Logic after a cart item is created
        Log::info('Cart Item created:', $cartItem->toArray());
    }

    public function updated(CartItem $cartItem)
    {
        // Logic after a cart item is updated
        Log::info('Cart Item updated:', $cartItem->toArray());
    }

    public function deleted(CartItem $cartItem)
    {
        // Logic after a cart item is deleted
        Log::info('Cart Item deleted:', $cartItem->toArray());
    }

    // You can add more methods for other events like restoring, forceDeleted, etc.
}
