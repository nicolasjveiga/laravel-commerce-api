<?php

namespace Database\Factories\Cart;

use App\Models\Cart\CartItem;
use App\Models\Cart\Cart;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'unitPrice' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}