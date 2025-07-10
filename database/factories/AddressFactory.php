<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
        ];
    }
}
