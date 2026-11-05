<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Cache;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->withCount('products');
            }])
            ->withCount('products')
            ->get();

        return CategoryResource::collection($categories);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->with('children')->firstOrFail();

        return new CategoryResource($category);
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
