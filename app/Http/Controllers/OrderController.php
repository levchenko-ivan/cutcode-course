<?php

namespace App\Http\Controllers;

use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;

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

    public function handle()
    {
        redirect()
            ->route('home');
    }
}
