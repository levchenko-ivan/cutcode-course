<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignInController;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class SignInControllerTest extends TestCase
{
    use CreateUserTrait;

    public function test_page(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_handle(): void
    {
        $user = $this->createUser();

        $request = [
            'email' => $user->email,
            'password' => '123456789'
        ];

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));
    }

    public function test_logout(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();
    }

    public function test_fail_values(): void
    {
        $response = $this->post(action([SignInController::class, 'handle']), [
            'email_' => '123',
            'password' => '123456789'
        ]);
        $response->assertSessionHasErrors(['email']);

        $response = $this->post(action([SignInController::class, 'handle']), [
            'email' => 'email@email',
            'password' => '123456789'
        ]);
        $response->assertSessionHasErrors(['email']);

        $response = $this->post(action([SignInController::class, 'handle']), [
            'email' => 'test@email.ru',
        ]);
        $response->assertSessionHasErrors(['password']);
    }
}
