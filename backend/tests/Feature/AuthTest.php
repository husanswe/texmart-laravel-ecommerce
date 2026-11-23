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


it('returns a token when user logs in with correct password', function() {
    $phone = '+998901237654';

    User::factory()->create([
        'phone' => $phone,
        'password' => 'SECRET789',
    ]);

    $response = $this->postJson('/api/v1/login', [
            'phone' => $phone, 
            'password' => 'SECRET789'
        ]);

    $response
        ->assertOk()
        ->assertJsonStructure(['token']);
});


it("rejects login with a wrong password", function() {
    $phone = '998998856458';
    
    User::factory()->create([
        'phone' => $phone,
        'password' => '321loremipsum',
    ]);

    $response = $this->postJson('/api/v1/login', [
        'phone' => $phone,
        'password' => 'SECRET789',
    ]);

    $response
        ->assertUnauthorized()
        ->assertJsonMissingPath('token');
});


it('returns 401 for /me without a token', function() {
    $response = $this->getJson('/api/v1/me');

    $response->assertUnauthorized();
});


it('deletes the tokens on logout', function() {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withToken($token)->postJson('/api/v1/logout');

    $response->assertOk();
        
    $this->assertDatabaseCount('personal_access_tokens', 0);
});