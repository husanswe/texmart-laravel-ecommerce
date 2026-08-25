<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => fake()->numerify(),
            'total_amount' => fake()->randomFloat(),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'shipping_address' => fake()->address(),
            'phone_number' => fake()->unique()->numerify('+998*********')
        ];
    }
}
