<?php

namespace Domain\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->register(
            ActionServiceProvider::class
        );

        $this->app->register(
            PaymentServiceProvider::class
        );
    }
}
