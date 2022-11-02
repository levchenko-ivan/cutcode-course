<?php

namespace Domain\Auth\Actions;

class LogOutAction
{
    public function __invoke()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }
}
