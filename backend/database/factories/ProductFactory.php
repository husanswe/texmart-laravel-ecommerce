<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;


class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => $name,
            'price' => fake()->randomFloat(nbMaxDecimals: 2, min: 100000, max: 100000000),
            'description' => fake()->paragraph(3),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100000),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}