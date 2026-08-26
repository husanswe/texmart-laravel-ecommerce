<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;


class AttributeValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'value' => fake()->randomElement(['8', '16', '32', '64', '128', '256', '512', 'Black', 'White', 'Blue', '6.5', '5000', '120']),
        ];
    }
}
