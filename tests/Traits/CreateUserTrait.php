<?php

namespace Tests\Traits;

use Database\Factories\UserFactory;
use Domain\Auth\Models\User;

trait CreateUserTrait
{
    protected function createUser(string $email = 'testing@mail.ru', string $password = '123456789'): User
    {
        return UserFactory::new()->create([
            'email'    => $email,
            'password' =>  bcrypt($password)
        ]);
    }
}
