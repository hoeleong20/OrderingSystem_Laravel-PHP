<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderUpdated;
use App\Listeners\KitchenListener;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderUpdated::class => [
            KitchenListener::class,
        ],
    ];


    public function boot()
    {
        parent::boot();
        Log::info('EventServiceProvider booted');
    }
}
