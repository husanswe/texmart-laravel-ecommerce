<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'name' => fake()->word(),
            'price' => fake()->randomFloat(100000, 100000000),
            'sku' => strtoupper(fake()->unique()->bothify('???-#####')),
            'stock' => fake()->numberBetween(0, 100)
        ];
    }
}
