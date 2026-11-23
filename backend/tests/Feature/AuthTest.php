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


it('rejects registration with a duplicate phone', function() {
    $phone = '+998901234567';

    User::factory()->create(['phone' => $phone]);

    $response = $this->postJson('/api/v1/register', [
        'name' => 'Husan',
        'phone' => $phone,
        'password' => 'secret456',
        'password_confirmation' => 'secret456',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors('phone');
});