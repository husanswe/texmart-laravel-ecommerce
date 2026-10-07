<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function addItem(Request $request, CartService $cartService): JsonResponse
    {
        $itemName = $request->input('name');
        
        $validated = $request->validate([
            'product_variant_id' => 'required',
                Rule::exists('product_variant_id'),
            'quantity' => 'required|int|min:1'
        ]);

        $cart = $cartService->addItemToCart(
            $validated['product_variant_id'],
            $validated['quantity']
        );

        return response()->json([
            'message' => "Tovar muvaffaqiyatli savatga qo'shildi",
            'data' => $cart
        ], 200);
    }
}
