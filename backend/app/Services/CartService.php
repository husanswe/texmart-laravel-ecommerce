<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\CartItem;

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

    public function addItem(Request $request, int $variantId, int $quantity)
    {
        $cart = $this->getOrCreateCart($request);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity
            ]);
        }

        return $cart->load('cartItems');
    }
}