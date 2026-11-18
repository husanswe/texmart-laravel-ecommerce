<?php

use App\Models\Category;


test('lists only parent categories', function () {
    $parent = Category::factory()->count(2)->create();
    Category::factory()->create(['parent_id' => $parent->first()->id]);

    $response = $this->getJson('/api/v1/categories');

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
}); 
