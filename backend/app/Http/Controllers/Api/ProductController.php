<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacetResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\AttributeValue;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images']);

        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereIn('category_id', (array) $request->category);
        });

        $query->when($request->filled('brand'), function ($q) use ($request) {
            $q->whereIn('brand_id', (array) $request->brand);
        });

        $query->when($request->filled('min_price'), function ($q) use ($request) {
            $q->where('price', '>=', $request->min_price);
        });

        $query->when($request->filled('max_price'), function ($q) use ($request) {
            $q->where('price', '<=', $request->max_price);
        });

        $query->when($request->boolean('in_stock'), function ($q) {
            $q->whereHas('variants', function ($variantQuery) {
                $variantQuery->where('stock', '>', 0);
            });
        });

        
        $filteredProductIds = (clone $query)->pluck('products.id');
        

        $facets = AttributeValue::with('attribute')->withCount([
            'product as product_count' => function ($q) use ($filteredProductIds) {
                $q->whereIn('products.id', $filteredProductIds);
            }
        ])->get();

        
        $query->when($request->filled('attribute_values'), function ($q) use ($request) {
            $q->whereHas('attributeValue', function ($attributeQuery) use ($request) {
                $attributeQuery->whereIn('attribute_values.id', $request->input('attribute_values'));
            });
        });
   
        
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        }
        
        if ($request->sort === 'price_desc') {
            $query->orderby('price', 'desc');
        }
        

        $products = $query->paginate(20)->withQueryString();


        return ProductResource::collection($products)->additional([
            'facets' => FacetResource::collection($facets)
        ]);
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