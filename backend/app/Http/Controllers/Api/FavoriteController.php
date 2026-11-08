<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class FavoriteController extends Controller
{
    public function index(Request $request)
    {   
        $user = $request->user();

        $favorites = $user->favoriteProducts()
            ->select('products.id', 'products.name', 'products.price', 'products.slug')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $favorites->items(),
            'meta' => [
                'current_page' => $favorites->currentPage(),
                'last_page' => $favorites->lastPage(),
                'total' => $favorites->total()
            ]
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = $request->user();

        $user->favoriteProducts()
            ->syncWithoutDetaching([
                $validated['product_id']
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Mahsulot sevimlilarga qo\'shildi.'
        ], 200);
    }


    public function destroy(Request $request, int $productId)
    {
        $user = $request->user();

        $user->favoriteProducts()
            ->detach($productId);

        return response()->json([
            'success' => true,
            'message' => 'Tovar sevimlilar ro\'yxatidan olib tashlandi.'
        ], 200);
    }

    /**
     * Called right after login: merges the guest's local favorites into the
     * account and returns the full list of favorite product ids.
     */
    public function sync(Request $request)
    {
        $request->validate([
            'ids' => 'present|array',
            'ids.*' => 'integer',
        ]);

        // Drop ids of products that no longer exist (e.g. after migrate:fresh)
        $ids = Product::whereIn('id', $request->input('ids', []))->pluck('id');

        $user = $request->user();
        $user->favoriteProducts()->syncWithoutDetaching($ids);

        return response()->json([
            'ids' => $user->favoriteProducts()->pluck('products.id'),
        ]);
    }
}
