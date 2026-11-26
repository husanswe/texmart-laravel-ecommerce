<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => fake()->unique()->numerify('ORD-########'),
            'total_amount' => fake()->randomFloat(2, 100000, 50000000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'shipping_address' => fake()->address(),
            'phone' => fake()->unique()->numerify('+998#########'),
            'user_id' => User::factory(),
        ];
    }
}