<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignUpController;
use App\Listeners\SendEmailNewUserListener;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class SignUpControllerTest extends TestCase
{
    use CreateUserTrait;

    public function test_page(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_handle(): void
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

    public function test_fail_values(): void
    {
        $response = $this->post(action([SignUpController::class, 'handle']), [
            'name' => 'Test',
            'password' => 'required|min:8|confirmed'
        ]);
        $response->assertSessionHasErrors(['email']);

        $response = $this->post(action([SignUpController::class, 'handle']), [
            'name' => 'Test',
            'email' => 'test@mail.ru',
        ]);
        $response->assertSessionHasErrors(['password']);

        $response = $this->post(action([SignUpController::class, 'handle']), [
            'name' => '_Test',
            'email' => 'test@mail.ru',
            'password' => '1234567890'
        ]);
        $response->assertSessionHasErrors(['password']);
    }
}
