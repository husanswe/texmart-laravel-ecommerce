<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;


it('returns paginated products with meta and links', function () {
    Product::factory()->count(25)->create();

    $response = $this->getJson('/api/v1/products');

    $response
        ->assertOk()
        ->assertJsonCount(20, 'data')
        ->assertJsonPath('meta.total', 25)
        ->assertJsonPath('meta.per_page', 20)
        ->assertJsonStructure([
            'data' => [
                "*" => [
                    'id',
                    'name',
                    'price',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
            'facets',
        ]);
});

it('returns the remaining products on page 2', function () {
    Product::factory()->count(25)->create();

    $response = $this->getJson('/api/v1/products?page=2');

    $response
        ->assertOk()
        ->assertJsonCount(5, 'data')
        ->assertJsonPath('meta.current_page', 2);
});

it('shows that category filter includes subcategories', function () {
    $parentCategory = Category::factory()->create(['slug' => 'smartfonlar']);
    $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);
    $tvCategory = Category::factory()->create(['slug' => 'televizorlar']);

    Product::factory()->create(['category_id' => $parentCategory->id]);
    Product::factory()->create(['category_id' => $childCategory->id]);
    Product::factory()->create(['category_id' => $tvCategory->id, 'name' => 'Samsung TV']);

    $response = $this->getJson('/api/v1/products?category=smartfonlar');

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonMissing(['name' => 'Samsung TV']);
});

it('filters product by brand', function () {
    $apple = Brand::factory()->create(['id' => 'apple']);
    $samsung = Brand::factory()->create(['id' => 'samsung']);

    Product::factory()->count(2)->create(['brand_id' => $apple->id]);
    Product::factory()->create(['brand_id' => $samsung->id, 'name' => 'Samsung Galaxy']);

    $response = $this->getJson("/api/v1/products?brand[]={$apple->id}");

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonMissing(['name' => 'Samsung Galaxy']);
});