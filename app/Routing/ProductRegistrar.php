<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class ProductRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                /**@see ProductController::class*/
                Route::get('/product/{product:slug?}', ProductController::class)
                    ->name('product');
            });
        });
    }
}
