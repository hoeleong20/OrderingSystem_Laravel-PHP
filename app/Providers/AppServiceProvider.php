<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;

use App\Models\CartItem;
use App\Observers\CartItemObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the observer
        Order::observe(OrderObserver::class);
        // Register the observer
        CartItem::observe(CartItemObserver::class);
    }
}
