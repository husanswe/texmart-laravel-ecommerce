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


it('removes a product from favorites', function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $product = Product::factory()->create();

    $user->favoriteProducts()->attach($product->id);

    $response = $this->deleteJson("/api/v1/favorites/{$product->id}");

    $response ->assertOk();
    $this->assertDatabaseCount('favorites', 0);
});


it('syncs favorites and skips deleted products', function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $product = Product::factory()->create();

    $response = $this->postJson('/api/v1/favorites/sync', ['ids' => [$product->id, 99999]]);

    $response
        ->assertOk()
        ->assertJsonCount(1, 'ids')
        ->assertJsonPath('ids.0', $product->id);

    $this->assertDatabaseCount('favorites', 1);
});