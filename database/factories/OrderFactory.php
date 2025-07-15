<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Coupon;
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