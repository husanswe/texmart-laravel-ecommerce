<?php

use App\Models\Brand;

it('returns all brands', function () {
    Brand::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/brands');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('sorts brands by name', function () {
    Brand::factory()->count(3)->sequence(
        ['name' => 'Xiaomi'], 
        ['name' => 'Apple'], 
        ['name' => 'Samsung'],
    )->create();

    $response = $this->getJson('/api/v1/brands');

    $response->assertOk();
    $response->assertJsonPath('0.name', 'Apple');
    $response->assertJsonPath('1.name', 'Samsung');
    $response->assertJsonPath('2.name', 'Xiaomi');
});