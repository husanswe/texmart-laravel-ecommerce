<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'image_path' => 'product-images/' . fake()->slug() . '.png',
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 5)
        ];
    }
}
