<?php

use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;

it('blocks guests from favorites', function () {
    $response = $this->getJson('/api/v1/favorites');

    $response->assertUnauthorized();
});
