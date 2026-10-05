<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $searchTerm = $request->input('q');

        $autocomplete = $request->boolean('autocomplete');

        if ($autocomplete) {
            return $this->autocomplete($searchTerm);
        }

        $products = Product::query()
            ->when($searchTerm, function ($q, $searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%");
        })
        ->paginate(10)
        ->withQueryString();

        return SearchResource::collection($products);
    }

    public function autocomplete(string $searchTerm): JsonResponse {

        if (strlen($searchTerm) < 2) {
            return response()->json([]);
        }

        return response()->json(
            Product::query()
            ->where('name', 'like', "%{$searchTerm}%")
            ->select('id', 'name', 'slug')
            ->limit(5)
            ->get()
        );
            
    }
}
