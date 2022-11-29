<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CartController;
use Illuminate\Contracts\Routing\Registrar;
use Route;

class CartRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function () {
            Route::controller(CartController::class)
                ->prefix('cart')
                ->group(function () {
                    Route::get('/', 'index')->name('cart');
                    Route::post('/{product}/add', 'add')->name('cart.add');
                    Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
                    Route::post('/{item}/delete', 'delete')->name('cart.delete');
                    Route::post('/truncate', 'truncate')->name('cart.truncate');
                });
        });
    }
}
