<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function () {

            Route::controller(SignInController::class)->group(function () {

                /**@see SignInController::page()*/
                Route::get('/login', 'page')
                    ->name('login');

                /**@see SignInController::handle()*/
                Route::post('/login', 'handle')
                    ->middleware('throttle:auth')
                    ->name('login.handle');

                /**@see SignInController::logOut()*/
                Route::delete('/logout', 'logOut')
                    ->name('logOut');
            });

            Route::controller(SignUpController::class)->group(function () {

                /**@see SignUpController::page()*/
                Route::get('/sign-up', 'page')
                    ->name('register');

                /**@see SignUpController::handle()*/
                Route::post('/sign-up', 'handle')
                    ->middleware('throttle:auth')
                    ->name('register.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {

                /**@see ForgotPasswordController::page()*/
                Route::get('/forgot-password', 'page')
                    ->middleware('guest')
                    ->name('forgot');

                /**@see ForgotPasswordController::handle()*/
                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')
                    ->name('forgot.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function () {

                /**@see ResetPasswordController::page()*/
                Route::get('/reset-password/{token}', 'page')->middleware('guest')->name('password.reset');

                /**@see ResetPasswordController::handle()*/
                Route::post('/reset-password', 'handle')->middleware('guest')->name('password-reset.handle');
            });

            Route::controller(SocialAuthController::class)->group(function (){

                /**@see SocialAuthController::redirects()*/
                Route::get('/auth/socialite/{driver}', 'redirects')
                    ->name('socialite.redirect');

                /**@see SocialAuthController::callback()*/
                Route::get('/auth/socialite/callback/{driver}', 'callback')
                    ->name('socialite.callback');
            });
        });
    }
}
