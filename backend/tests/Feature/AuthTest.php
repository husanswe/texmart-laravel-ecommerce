<?php

use App\Models\User;

it('registers a user and returns a token', function () {
    $phone = '+998901234567';

    $response = $this->postJson('/api/v1/register', [
        'name' => 'John Doe',
        'phone' => $phone,
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonStructure(['token', 'user']);

    $this->assertDatabaseHas('users', ['phone' => $phone]);
});
