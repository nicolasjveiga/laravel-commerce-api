<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'stock' => $this->faker->randomFloat(2, 0, 100),
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}