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
        $cart = $cartService->getOrCreateCart($request)
            ->load('cartItems.productVariant.product.productImage');

        $items = $cart->cartItems->map(function ($item) {
            $variant = $item->productVariant;
            $product = $variant->product;
            $image   = $product->productImage->sortBy('sort_order')->first();
            $slug    = is_array($product->slug) ? ($product->slug['uz'] ?? '') : $product->slug;

            return [
                'id'           => $item->id,
                'quantity'     => $item->quantity,
                'variant_id'   => $variant->id,
                'product_id'   => $product->id,
                'name'         => $product->name,
                'variant_name' => $variant->name,
                'sku'          => $variant->sku,
                'slug'         => $slug,
                'price'        => $variant->price,
                'line_total'   => $variant->price * $item->quantity,
                'stock'        => $variant->stock,
                'image'        => $image ? asset('storage/' . $image->image_path) : null,
            ];
        });

        return response()->json([
            'items'      => $items->values(),
            'total'      => $items->sum('line_total'),
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

    public function update(Request $request, CartService $cartService, int $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $cartService->updateItem(
            $request,
            $id,
            $validated['quantity']
        );

        return response()->json([
            'message' => 'Savatdagi mahsulot miqdori yangilandi.',
            'data' => $cart
        ], 200);
    }

    public function destroy(Request $request, CartService $cartService, int $id)
    {
        $cart = $cartService->removeItem($request, $id);

        return response()->json([
            'message' => "Mahsulot savatdan o'chirildi",
            'data' => $cart
        ], 200);
    }
}