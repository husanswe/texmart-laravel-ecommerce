<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_variant_id' => ProductVariant::factory(),
            'product_name' => fake()->words(2, true),
            'sku' => strtoupper(fake()->unique()->bothify('???-#####')),
            'price_at_purchase' => fake()->numberBetween(100000, 25000000),
            'qunatity' => fake()->numberBetween(1, 9)
        ];
    }
}
