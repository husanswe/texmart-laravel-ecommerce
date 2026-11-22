<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;


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
    $apple = Brand::factory()->create(['name' => 'apple']);
    $samsung = Brand::factory()->create(['name' => 'samsung']);

    Product::factory()->count(2)->create(['brand_id' => $apple->id]);
    Product::factory()->create(['brand_id' => $samsung->id, 'name' => 'Samsung Galaxy']);

    $response = $this->getJson("/api/v1/products?brand[]={$apple->id}");

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonMissing(['name' => 'Samsung Galaxy']);
});

it('filters products by price', function () {
    Product::factory()->count(3)->sequence(
        ['price' => 1000000, 'name' => 'Cheap'],
        ['price' => 5000000, 'name' => 'Middle'],
        ['price' => 9000000, 'name' => 'Expensive'],
    )->create();

    $response = $this->getJson('/api/v1/products?min_price=2000000&max_price=8000000');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'Middle');
});

it('filters products by stock', function () {
    $availableProduct = Product::factory()->create([
        'name' => 'Available',
    ]);

    $soldOutProduct = Product::factory()->create([
        'name' => 'Sold Out',
    ]);

    ProductVariant::factory()->create(['product_id' => $availableProduct->id]);
    ProductVariant::factory()->outOfStock()->create(['product_id' => $soldOutProduct->id]);

    $response = $this->getJson('/api/v1/products?in_stock=1');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'Available');
});

it('sorts products by price ascending', function () {
    Product::factory()->count(3)->sequence(
        ['price' => 5000000, 'name' => 'Middle'],
        ['price' => 9000000, 'name' => 'Expensive'],
        ['price' => 1000000, 'name' => 'Cheap'],
    )->create();

    $response = $this->getJson('/api/v1/products?sort=price_asc');

    $response
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Cheap')
        ->assertJsonPath('data.1.name', 'Middle')
        ->assertJsonPath('data.2.name', 'Expensive');
});

it('sorts products by price descending', function () {
    Product::factory()->count(3)->sequence(
        ['price' => 5000000, 'name' => 'Middle'],
        ['price' => 1000000, 'name' => 'Cheap'],
        ['price' => 9000000, 'name' => 'Expensive'],
    )->create();

    $response = $this->getJson('/api/v1/products?sort=price_desc');

    $response
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Expensive')
        ->assertJsonPath('data.1.name', 'Middle')
        ->assertJsonPath('data.2.name', 'Cheap');
});