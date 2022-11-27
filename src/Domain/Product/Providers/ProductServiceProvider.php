<?php

namespace Domain\Product\Providers;

use Carbon\Laravel\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->register(
            ActionServiceProvider::class
        );
    }
}
