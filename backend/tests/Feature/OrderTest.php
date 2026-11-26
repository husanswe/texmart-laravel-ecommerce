<?php

use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Queue;


it('places an order, reduces stock and empties the cart', function () {
    Queue::fake();

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $variant = ProductVariant::factory()->create([
        'price' => 2500000,
        'stock' => 10,
    ]);

    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_variant_id' => $variant->id,
        'quantity' => 2,
    ]);

    $response = $this->postJson('/api/v1/orders', [
        'shipping_address' => "ABC Street 123, Tashkent City",
        'phone' => '+998998856458'
    ]);

    $response->assertCreated();
    
    $this
        ->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_amount' => 5000000,
        ])

        ->assertDatabaseCount('cart_items', 0)

         ->assertDatabaseHas('product_variants', [
            'id' => $variant->id,
            'stock' => 8,
    ]);

});


it('rejects checkout with an empty cart', function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/v1/orders', [
        'shipping_address' => "ABC Street 123, Tashkent City",
        'phone' => "+998998856458",
    ]);

    $response 
        ->assertUnprocessable()
        ->assertJsonValidationErrors('cart');
        
    $this->assertDatabaseCount('orders', 0);
});
