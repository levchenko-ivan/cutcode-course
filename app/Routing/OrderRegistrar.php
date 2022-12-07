<?php

namespace App\Routing;

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

class OrderRegistrar
{
    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function () {
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::post('/order', [OrderController::class, 'handle'])->name('order.handle');
        });
    }
}
