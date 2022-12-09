<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;

class OrderController
{
    public function index()
    {
        $items = cart()->items();

        if($items->isEmpty()) {
            throw new \DomainException('Корзина пуста');
        }

        return view('order.order-page', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    public function handle(OrderFormRequest $request): RedirectResponse
    {
        dd($request->all());
        return redirect()
            ->route('home');
    }
}
