<?php

namespace Database\Factories\Cart;

use App\Models\Cart\Cart;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'createdAt' => now(),
        ];
    }
}