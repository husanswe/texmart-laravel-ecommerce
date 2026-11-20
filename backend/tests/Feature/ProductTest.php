<?php

use App\Models\Product;


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