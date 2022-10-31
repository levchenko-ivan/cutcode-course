<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function callback(string $driver): Redirector|Application|RedirectResponse
    {
        if($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver.'_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? 'GitHubUser_'.$githubUser->id,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20))
        ]);

        auth()->login($user);

        return redirect()
            ->intended(route('home'));
    }
}
