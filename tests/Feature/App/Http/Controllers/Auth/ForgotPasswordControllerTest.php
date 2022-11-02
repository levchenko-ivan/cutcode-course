<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Support\Flash\Flash;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class ForgotPasswordControllerTest extends TestCase
{
    use CreateUserTrait;

    public function test_page(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_handle(): void
    {
        Event::fake();

        $user = $this->createUser();

        $response = $this->post(action([ForgotPasswordController::class, 'handle']), [
            'email' => $user->email
        ]);

        $response->assertValid();

        $response->assertRedirect();

        $response->assertSessionHasNoErrors();

        $response->assertSessionHas([Flash::MESSAGE_KEY => __(Password::RESET_LINK_SENT)]);
    }

    public function test_fail_email()
    {
        $response = $this->post(action([ForgotPasswordController::class, 'handle']), [
            'email_' => '123'
        ]);
        $response->assertSessionHasErrors(['email']);

        $response = $this->post(action([ForgotPasswordController::class, 'handle']), [
            'email' => 'email@email'
        ]);
        $response->assertSessionHasErrors(['email']);
    }
}
