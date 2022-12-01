<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;

class SocialiteAuthAction
{
    private $drivers = [
        'github'
    ];

    public function __invoke(string $driver): void
    {

        if(!in_array($driver, $this->drivers)) {
            throw new DomainException('Драйвер не поддерживается');
        }

        $socialiteUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver.'_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName() ?? 'GitHubUser_'.$socialiteUser->getId(),
            'email' => $socialiteUser->getEmail(),
            'password' => bcrypt(str()->random(20))
        ]);

        SessionRegenerator::run(fn() => auth()->login($user));
    }
}
