<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category', 'images'])->paginate(10);

        return ProductResource::collection($products);
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
