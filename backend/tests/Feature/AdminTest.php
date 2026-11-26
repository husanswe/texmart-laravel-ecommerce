<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;


it('blocks guests from the admin dashboard', function () {
    $response = $this->getJson('/api/v1/admin/dashboard');

    $response->assertUnauthorized();
});


it('forbids normal users from the admin dashboard', function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->getJson('/api/v1/admin/dashboard');

    $response->assertForbidden();
});