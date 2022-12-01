<?php

namespace Tests\Traits;

use Database\Factories\ProductFactory;

trait FillCartTrait
{
    public function addTestProduct(
        int $quantity = 1,
        array $optionValues = []
    )
    {
        $product = ProductFactory::new()->create();
        cart()->add($product, $quantity, $optionValues);
        return $product;
    }

}
