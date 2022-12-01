<?php

namespace Domain\Cart\Providers;

use Carbon\Laravel\ServiceProvider;
use Domain\Cart\CartManager;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(
            ActionServiceProvider::class
        );
    }

    public function boot()
    {
        $this->app->bind(
            CartIdentityStorageContract::class,
            SessionIdentityStorage::class
        );

        $this->app->singleton(CartManager::class);
    }
}
