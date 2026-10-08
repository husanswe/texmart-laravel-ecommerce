<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
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

    public function addItem(Request $request, CartService $cartService): JsonResponse
    {        
        $validated = $request->validate([
            'product_variant_id' => 'required|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $cartService->addItem(
            $request,
            $validated['product_variant_id'],
            $validated['quantity']
        );

        return response()->json([
            'message' => "Tovar muvaffaqiyatli savatga qo'shildi",
            'data' => $cart
        ], 200);
    }
}
