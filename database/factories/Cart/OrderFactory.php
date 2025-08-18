<?php

namespace Database\Factories\Cart;

use App\Models\Cart\Order;
use App\Models\User\User;
use App\Models\User\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'coupon_id' => null,
            'orderDate' => now(),
            'status' => 'PENDING',
            'totalAmount' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}