<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images']);

        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereIn('category_id', $request->category);
        });

        $query->when($request->filled('brand'), function ($q) use ($request) {
            $q->whereIn('brand_id', $request->brand);
        });

        return ProductResource::collection($query->paginate(20));
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->with('brand', 'category', 'images', 'variants')->firstOrFail();

        return new ProductResource($product);
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