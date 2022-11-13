<?php

namespace Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    public function test_user_create()
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@mail.ru'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test', 'test@mail.ru', '123456789'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@mail.ru'
        ]);
    }
}
