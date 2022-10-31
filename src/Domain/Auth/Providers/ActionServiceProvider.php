<?php

namespace Domain\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class
    ];
}
