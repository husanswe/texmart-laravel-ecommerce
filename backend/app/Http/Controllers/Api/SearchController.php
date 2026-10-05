<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $searchTerm = $request->input('q');

        $products = Product::query()->when($searchTerm, function ($q, $searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%");
        })->paginate(20)->withQueryString();

        return SearchResource::collection($products);
    }
}
