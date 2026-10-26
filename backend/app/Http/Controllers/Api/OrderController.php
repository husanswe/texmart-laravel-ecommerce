<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        // 
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)
            ->with('cartItems')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Savat bo\'sh yoki mavjud emas.'
            ]);
        }


        $order = DB::transaction(function() use($user, $cart, $validated) {
            $totalAmount = 0;

            foreach ($cart->cartItems as $cartItem) {
                $variant = ProductVariant::where('id', $cartItem->product_variant_id)
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            if ($cartItem->quantity > $variant->stock) {
                throw ValidationException::withMessages([
                    'cart' => 'Mahsulot zaxirasi yetarli emas.'
                ]);
            }

            $lineTotal = $variant->price * $cartItem->quantity;
            $totalAmount += $lineTotal;
        });
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
