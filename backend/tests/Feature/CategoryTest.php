<?php

use App\Models\Category;


it('lists only parent categories', function () {
    $parent = Category::factory()->count(2)->create();
    Category::factory()->create(['parent_id' => $parent->first()->id]);

    $response = $this->getJson('/api/v1/categories');

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
}); 

it('returns a category by slug', function() {
    Category::factory()->create(['slug' => 'smartfonlar']);

    $response = $this->getJson('/api/v1/categories/smartfonlar');

    $response->assertOk();
    $response->assertJsonPath('data.slug', 'smartfonlar');
});

it('includes the children', function () {
    $parent = Category::factory()->create(['slug' => 'smartfonlar']);
    Category::factory()->count(2)->create(['parent_id' => $parent->id]);

    $response = $this->getJson('/api/v1/categories/{$parent->slug}');

    $response->assertOk();
    $response->assertJsonCOunt(2, 'data.children');
});