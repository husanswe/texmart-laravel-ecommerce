<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index(Request $request, CartService $cartService)
    {
        $cart = $cartService->getOrCreateCart($request);

        return response()->json([
            'cart' => $cart,
            'cart_token' => $cart->session_id,
        ]);
    }

    public function addItem(Request $request) 
    {
        $itemName = $request->input('name');
        
        $validated = $request->validate([
            'product_variant_id' => 'required|string|max:255'
        ]);
    }
}
