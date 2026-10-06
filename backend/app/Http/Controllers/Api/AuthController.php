<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
            'message' => "Foydalanuvchi muvaffaqiyatli ro'yxatdan o'tdi!", 
            'user' => $user,
            'token' => $token
            ], 201);
    }

    public function login(LoginRequest $request) {
        $validatedData = $request->validated();

        $user = User::where('phone', $validatedData['phone'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => "Telefon raqam yoki parol noto'g'ri."
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => "Tizimga muvafaqiyatli kirildi!",
            'user' => $user,
            'token' => $token
        ]);
    }
}
