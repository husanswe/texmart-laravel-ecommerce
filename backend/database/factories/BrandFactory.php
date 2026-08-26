<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->Str::slug('name'),
            'logo_path' => 'brands/' . fake()->slug() . '.png'
        ];
    }
}
