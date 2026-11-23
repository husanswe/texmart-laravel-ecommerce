<?php

use App\Models\ProductVariant;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


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


it('shows the guest cart for the same token', function() {
    $variant = ProductVariant::factory()->create([
        'price' => 1000000,
        'stock' => 5
    ]);
    $token = 'test-token-123';

    $this->withHeader('X-Cart-Token', $token)->postJson('/api/v1/cart/items', [
        'product_variant_id' => $variant->id,
        'quantity' => 2,
    ]);

    $response = $this->withHeader('X-Cart-Token', $token)->getJson('/api/v1/cart');
    
    $response
        ->assertOk()
        ->assertJsonCount(1, 'items')
        ->assertJsonPath('cart_token', $token);

    expect($response->json('total'))->toEqual(2000000);
});


it('adds an item to the logged-in user cart', function() {
    $variant = ProductVariant::factory()->create([
        'price' => 1000000,
        'stock' => 5
    ]);

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/v1/cart/items', [
        'product_variant_id' => $variant->id,
        'quantity' => 2,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('carts', ['user_id' => $user->id])
         ->assertDatabaseHas('cart_items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2
        ]);
});
