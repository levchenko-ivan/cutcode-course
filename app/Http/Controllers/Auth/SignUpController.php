<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
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
        //TODO make DTO
        $data = $request->validated();

        /**
         * @var $action RegisterNewUserAction
         */
        $action(
            $data['name'],
            $data['email'],
            $data['password']
        );

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}
