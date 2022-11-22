<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CatalogController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class CatalogRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function () {
            Route::controller(CatalogController::class)->group(function () {
                /**@see CatalogController::page()*/
                Route::get('/catalog/{category:slug?}', 'page')
                    ->name('catalog');
            });
        });
    }
}
