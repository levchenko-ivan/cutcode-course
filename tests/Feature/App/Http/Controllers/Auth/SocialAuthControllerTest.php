<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Services\Telegram\Exceptions\TelegramApiException;
use Support\Flash\Flash;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    public function test_redirect(): void
    {
        $this->get(action([SocialAuthController::class, 'redirects'], ['driver' => 'github']))
            ->assertRedirect();
    }

    public function test_callback(): void
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn('TestGit')
            ->shouldReceive('getEmail')
            ->andReturn('test@mail.ru');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('github')->andReturn($provider);

        $this->get(action([SocialAuthController::class, 'callback'], ['driver' => 'github']))
            ->assertRedirect();
    }

    public function test_fail_driver_redirect(): void
    {
        $response = $this
            ->from(route('login'))
            ->get(action([SocialAuthController::class, 'redirects'], ['driver' => 'errorDriver']))
            ->assertRedirect(route('login'));
        $response->assertSessionHas(Flash::MESSAGE_KEY, 'Произошла ошибка или драйвер не поддерживается: errorDriver');
    }

    public function test_fail_driver_callback(): void
    {
        $response = $this->get(action([SocialAuthController::class, 'callback'], ['driver' => 'errorDriver']));

        $response->assertSessionHas(Flash::MESSAGE_KEY, 'Драйвер не поддерживается');

        $response->assertRedirect();
    }
}
