<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Support\Flash\Flash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function is_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
        ->assertOk()
        ->assertSee('Вход в аккаунт')
        ->assertViewIs('auth.login');
    }

    /**
     * @test
     * @return void
     */
    public function is_sign_up_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    /**
     * @test
     * @return void
     */
    public function is_forgot_password_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     * @return void
     */
    public function is_reset_success(): void
    {
        $this->get(action([ResetPasswordController::class, 'page'], ['token' => 'test']))
            ->assertOk()
            ->assertSee('Восстановление пароля')
            ->assertViewIs('auth.reset-password');
    }

    /**
     * @test
     * @return void
     */
    public function is_sign_in_success(): void
    {
        $password ='123456789';

        $user = UserFactory::new()->create([
            'email'    => 'testing@mail.ru',
            'password' =>  bcrypt($password)
        ]);

        $request = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     */
    public function is_logout_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();
    }

    /**
     * @test
     * @return void
     */
    public function is_forgot_password_post_success(): void
    {
        Event::fake();

        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
        ]);

        $response = $this->post(action([ForgotPasswordController::class, 'handle']), [
            'email' => $user->email
        ]);

        $response->assertValid();

        $response->assertRedirect();

        $response->assertSessionHasNoErrors();

        $response->assertSessionHas([Flash::MESSAGE_KEY => __(Password::RESET_LINK_SENT)]);
    }

    /**
     * @test
     * @return void
     */
    public function is_reset_password_post_success(): void
    {
        Event::fake();

        $user = UserFactory::new()->create([
            'password' => bcrypt('123456789'),
            'email' => 'testing@mail.ru'
        ]);

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

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function is_store_success(): void
    {
        Event::fake();

        $request = [
            'name'     => 'Test',
            'email'    => 'testing@email.ru',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        Event::assertDispatched(Registered::class);

        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $user = User::query()->where('email', $request['email'])->first();

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_send_email_new_user_listener_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
        ]);

        Notification::fake();

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);
    }
}
