<?php

use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;

it('blocks guests from favorites', function () {
    $response = $this->getJson('/api/v1/favorites');

    $response->assertUnauthorized();
});


it('adds a product to favorites without duplicates', function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $product = Product::factory()->create();

    $first = $this->postJson('/api/v1/favorites', ['product_id' => $product->id]);
    $second = $this->postJson('/api/v1/favorites', ['product_id' => $product->id]);

    $first->assertOk();
    $second->assertOk();

    $this->assertDatabaseCount('favorites', 1);
});