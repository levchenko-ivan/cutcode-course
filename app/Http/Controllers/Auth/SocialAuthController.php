<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Actions\SocialiteAuthAction;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirects(string $driver): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        try {
            return  Socialite::driver($driver)
                ->redirect();
        } catch (Throwable $e) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается: '.$driver);
        }
    }

    public function callback(string $driver, SocialiteAuthAction $action): Redirector|Application|RedirectResponse
    {
        $action($driver);

        return redirect()
            ->intended(route('home'));
    }
}
