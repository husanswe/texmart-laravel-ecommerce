<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100000),
            'icon' => fake()->randomElement(['smartphone', 'laptop', 'tv', 'refrigerator', 'washing-machine', 'headphones', 'camera', 'watch']),
        ];
    }
}
