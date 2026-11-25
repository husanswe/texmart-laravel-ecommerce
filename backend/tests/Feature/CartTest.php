<?php

use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
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


it('rejects adding more than the stock', function() {
    $variant = ProductVariant::factory()->create(['stock' => 5]);
    $token = 'test-token-007';

    $response = $this->withHeader('X-Cart-Token', $token)
        ->postJson('/api/v1/cart/items', [
            'product_variant_id' => $variant->id,
            'quantity' => 6,
        ]);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors('quantity');

    $this->assertDatabaseCount('cart_items', 0);
});

it('allows adding exactly the available stock', function() {
    $variant = ProductVariant::factory()->create(['stock' => 5]);
    $token = 'test-token-007';

    $response = $this->withHeader('X-Cart-Token', $token)
        ->postJson('/api/v1/cart/items', [
            'product_variant_id' => $variant->id,
            'quantity' => 5,
        ]);

    $response->assertOk();
    $this->assertDatabaseHas('cart_items', [
        'product_variant_id' => $variant->id,
        'quantity' => 5,
    ]);
});


it('allows decreasing quantity even above stock', function() {
    $variant = ProductVariant::factory()->create(['stock' => 5]);
    $token = 'test-token-456';

    $cart = Cart::factory()->create(['user_id' => null, 'session_id' => $token]);
    $item = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_variant_id' => $variant->id,
        'quantity' => 8,
    ]);

    $response = $this->withHeader('X-Cart-Token', $token)
        ->putJson("/api/v1/cart/items/{$item->id}", ['quantity' => 6]);

    $response->assertOk();
    $this->assertDatabaseHas('cart_items', [
        'id' => $item->id,
        'quantity' => 6,
    ]);
});


it('removes an item from the cart', function() {
    $token = 'test-token-loremipsum';
    $cart = Cart::factory()->create(['user_id' => null, 'session_id' => $token]);
    $item = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'quantity' => 5,
    ]);

    $response = $this->withHeader('X-Cart-Token', $token)
        ->deleteJson("/api/v1/cart/items/{$item->id}");

    $response->assertOk();
    $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
});


it('cannot delete an item from another cart', function() {
    $token1 = 'test-token-xxx';
    $token2 = 'second-test-token';
    $cart = Cart::factory()->create(['user_id' => null, 'session_id' => $token1]);
    $item = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'quantity' => 2,
    ]);

    $response = $this->withHeader('X-Cart-Token', $token2)
        ->deleteJson("/api/v1/cart/items/{$item->id}");
    
    $response->assertNotFound();

    $this->assertDatabaseHas('cart_items', ['id' => $item->id]);
});


it('merges the guest cart into the user on register', function() {
    $phone = '+998909876543';
    $token = 'second-test-token';
    $guestCart = Cart::factory()->create(['user_id' => null, 'session_id' => $token]);
    $item = CartItem::factory()->create([
        'cart_id' => $guestCart->id,
        'quantity' => 2,
    ]);

    $response = $this->withHeader('X-Cart-Token', $token)
        ->postJson('/api/v1/register', [
            'name' => 'John Doe',
            'phone' => $phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

    $this->assertDatabaseMissing('carts', ['session_id' => $token]);
});