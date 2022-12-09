<?php

namespace Domain\Order\Processes;

use DB;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

class DecreaseProductsQuantities implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            $item->product()->update([
                'quantity' => DB::raw('quantity - '.$item->quantity)
            ]);
        }
        return $next($order);
    }
}
