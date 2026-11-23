<?php

use App\Models\User;

it('registers a user and returns a token', function () {
    $response = $this->postJson('/api/v1/register', [
        'name' => 'John Doe',
        $phone = 'phone' => '+998901234567',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonStructure(['token' => '', 'user' => 'John Doe']);

    $this->assertDatabaseHas('users', ['phone' => $phone]);
});
