<?php

use App\Models\Brand;

it('returns all brands', function () {
    Brand::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/brands');

    $response->assertOk();
    $response->assertJsonCount(3);
});
