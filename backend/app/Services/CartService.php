<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartService
{
    public function getOrCreateCart(Request $request) 
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $cart = Cart::firstOrCreate([
                'user_id' => $user->id,
                'session_id' => null
            ]);

            return $cart;
        }


        $cartToken = $request->header('X-Cart-Token');

        if($cartToken) {
            $cart = Cart::where('session_id', $cartToken)->first();

            if($cart) {
                return $cart;
            }
        }

        $cartToken = (string) Str::uuid();

        return Cart::create([
            'user_id' => null,
            'session_id' => $cartToken
        ]);
    }
}
