<?php

namespace Domain\Cart;

use DB;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Product\Models\Product;

class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    )
    {
    }

    private function storageData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if(auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function stringedOptionValues(array $optionValues)
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = [])
    {
        $cart = Cart::query()
            ->updateOrCreate([
                'storage_id' => $this->identityStorage->get()
            ], $this->storageData($this->identityStorage->get()));

        $cartItem = $cart->cartItems()
            ->updateOrCreate([
                'product_id' => $product->getKey(),
                'string_option_values' => $this->stringedOptionValues($optionValues)
            ], [
                'price' => $product->price,
                'quantity' => DB::raw("quantity + $quantity"),
                'string_option_values' => $this->stringedOptionValues($optionValues)
            ]);

        $cartItem->optionValues()->sync($optionValues);

        return $cart;
    }

}
