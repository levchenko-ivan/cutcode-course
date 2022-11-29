<?php

namespace App\Http\Controllers;


use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('cart.cart');
    }

    public function add(Product $product): RedirectResponse
    {
        flash()->info('Товар добавлен в корзину');

        return redirect()
            ->intended(route('cart'));
    }

    public function quantity(): RedirectResponse
    {
        flash()->info('Количество товаров изменено');
        return redirect()
            ->intended(route('cart'));
    }

    public function delete()
    {
        flash()->info('Удалено из корзины');
        return redirect()
            ->intended(route('cart'));
    }

    public function truncate()
    {
        flash()->info('Очищено');
        return redirect()
            ->intended(route('cart'));
    }
}
