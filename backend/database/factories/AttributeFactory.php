<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class AttributeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => Str::slug('name'),
            'unit' => fake()->optional()->randomElement(['GB', 'inch', 'MHz', 'mAh', 'MP', 'kg', 'L', 'W'])
        ];
    }
}
