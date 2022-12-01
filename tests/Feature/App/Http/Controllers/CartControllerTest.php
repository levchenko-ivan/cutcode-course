<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Tests\TestCase;
use Tests\Traits\FillCartTrait;

class CartControllerTest extends TestCase
{
    use FillCartTrait;

    public function setUp(): void
    {
        parent::setUp();
        CartManager::fake();
    }


    public function test_empty_cart()
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.cart')
            ->assertViewHas('items', collect([]))
        ;
    }

    public function test_is_not_empty_cart()
    {
        $this->addTestProduct();

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.cart')
            ->assertViewHas('items', cart()->items())
        ;
    }

    public function test_added()
    {
        $this->assertEquals(0, cart()->count());

        $product = ProductFactory::new()->create();

        $this->post(action([CartController::class, 'add'], $product),
            ['quantity' => 4]
        );

        $this->assertEquals(4, cart()->count());
    }

    public function test_quantity()
    {
        $this->addTestProduct(4);

        $this->post(
            action([CartController::class, 'quantity'],
                cart()->items()->first()),
            ['quantity' => 8]
        );

        $this->assertEquals(8, cart()->count());
    }

    public function test_delete()
    {
        $this->addTestProduct(4);

        $this->delete(
            action([CartController::class, 'delete'],
                cart()->items()->first())
        );

        $this->assertEquals(0, cart()->count());
    }

    public function test_truncate()
    {
        cart()->truncate();

        $this->addTestProduct(4);

        $this->delete(
            action([CartController::class, 'truncate'],
                cart()->items()->first())
        );

        $this->assertEquals(0, cart()->count());
    }
}
