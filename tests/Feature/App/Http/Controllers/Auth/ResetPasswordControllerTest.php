<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Support\Flash\Flash;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class ResetPasswordControllerTest extends TestCase
{
    use CreateUserTrait;

    public function test_page(): void
    {
        $this->get(action([ResetPasswordController::class, 'page'], ['token' => 'test']))
            ->assertOk()
            ->assertSee('Восстановление пароля')
            ->assertViewIs('auth.reset-password');
    }

    public function test_handle(): void
    {
        Event::fake();

        $user = $this->createUser();

        $token = Password::broker()->createToken($user);

        $password = '1234567810';

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => $token,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ])
            ->assertValid()
            ->assertRedirect();

        Event::assertDispatched(PasswordReset::class);

        $response->assertSessionHas([Flash::MESSAGE_KEY => __(Password::PASSWORD_RESET)]);
    }

    public function test_fail_values(): void
    {
        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        $response->assertSessionHasErrors(['email']);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'email' => 'test@mail.ru',
            'password' => 'required|min:8|confirmed'
        ]);
        $response->assertSessionHasErrors(['token']);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => 'required',
            'email' => 'test@mail.ru',
        ]);
        $response->assertSessionHasErrors(['password']);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => 'required',
            'email' => 'test@mail.ru',
            'password' => 'required|min:8|confirmed'
        ]);
        $response->assertSessionHasErrors(['password']);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => 'required',
            'email' => 'test@mail.ru',
            'password' => '1',
            'password_confirmation' => '1'
        ]);
        $response->assertSessionHasErrors(['password']);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'token' => 'required',
            'email' => 'test@mail.ru',
            'password' => '123456789',
            'password_confirmation' => '123456781'
        ]);
        $response->assertSessionHasErrors(['password']);
    }
}
