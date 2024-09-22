<?php

namespace App\Observers;

use App\Models\CartItem;
use App\Http\Controllers\CartItemController;

use Illuminate\Support\Facades\Log;

class CartItemObserver
{
    public function created(CartItem $cartItem)
    {
        // Logic after a cart item is created
        Log::info('Cart Item created:', $cartItem->toArray());

        // // Call the method to send cart items to Java program
        // $cartItemController = new CartItemController();
        // $cartItemController->sendCartItemsToJava();
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
