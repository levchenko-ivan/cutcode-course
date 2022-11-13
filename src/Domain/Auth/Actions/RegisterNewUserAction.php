<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $user)
    {
        $user = User::query()->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => bcrypt($user->password)
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}
