<?php

use App\Models\ProductVariant;
use App\Models\Cart;

it('lets a guest add an item to the cart', function () {
    $variant = ProductVariant::factory()->create(['stock' => 10]);
    $token = 'test-token-123';

    $response = $this->withHeader('X-Cart_Token', $token)
        ->postJson('/api/v1/cart/items', [
        'product_variant_id' => $variant->id,
        'quantity' => 2,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('carts', ['session_id' => $token])
        ->assertDatabaseHas('cart_items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);
});
