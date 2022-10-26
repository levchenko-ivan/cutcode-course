<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Vite;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Vite::macro('image', fn($asset) => $this->asset("resources/images/$asset"));
    }
}
