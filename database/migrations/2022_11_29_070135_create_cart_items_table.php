<?php

use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Cart::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('price');

            $table->integer('quantity');

            $table->string('string_option_values')
                ->nullable();

            $table->timestamps();
        });

        Schema::create('cart_item_option_value', function (Blueprint $table) {
            $table->foreignIdFor(CartItem::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        if(app()->isProduction()) {
            return;
        }
        Schema::dropIfExists('cart_items');
    }
};
