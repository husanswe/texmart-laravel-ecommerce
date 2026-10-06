<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']) 
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully!', 
            'user' => $user
            ], 201);
    }
}
