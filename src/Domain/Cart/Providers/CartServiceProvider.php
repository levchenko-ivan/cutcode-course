<?php

namespace Domain\Cart\Providers;

use Carbon\Laravel\ServiceProvider;
use Domain\Cart\CartManager;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(CartManager::class, function () {
            return new CartManager(new SessionIdentityStorage());
        });
    }


    public function register()
    {
        $this->app->register(
            ActionServiceProvider::class
        );
    }
}
