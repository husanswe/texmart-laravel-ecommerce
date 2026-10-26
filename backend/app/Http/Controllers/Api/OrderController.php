<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
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


        $order = DB::transaction(function() use($user, $validated) {

            $cart = Cart::where('user_id', $user->id)
            ->with('cartItems')
            ->first();

            if (!$cart || !$cart->cartItems->exists()) {
                throw ValidationException::withMessages([
                    'cart' => 'Savat bo\'sh yoki mavjud emas.'
                ]);
            }

            $cart->load('cartItems');


            $totalAmount = 0;

            foreach ($cart->cartItems as $cartItem) {
                $variant = ProductVariant::where('id', $cartItem->product_variant_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($cartItem->quantity > $variant->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Mahsulot zaxirasi yetarli emas.'
                    ]);
                }

                $lineTotal = $variant->price * $cartItem->quantity;
                $totalAmount += $lineTotal;
            }


            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . Str::uuid(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'phone' => $validated['phone']
            ]);

            foreach ($cart->cartItems as $cartItem) {
                $variant = ProductVariant::findOrFail($cartItem->product_variant_id);
                
                OrderItem::create([
                    'order_id' => $order->id, 
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product->name,  
                    'sku' => $variant->sku, 
                    'price_at_purchase' => $variant->price, 
                    'quantity' => $cartItem->quantity
                ]);
                
                $variant->decrement('stock', $cartItem->quantity);
            }


            $cart->cartItems()->delete();

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully.',
            'data' => $order
        ], 201);
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
