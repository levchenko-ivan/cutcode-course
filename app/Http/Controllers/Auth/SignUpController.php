<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SignUpController extends Controller
{
    public function page(): Factory|View|Application
    {
        return view('auth.sign-up');
    }

    public function handle(
        SignUpFormRequest $request,
        RegisterNewUserContract $action
    ): RedirectResponse
    {
        /**
         * @var $action RegisterNewUserAction
         */
        $action(NewUserDTO::fromRequest($request));

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}
