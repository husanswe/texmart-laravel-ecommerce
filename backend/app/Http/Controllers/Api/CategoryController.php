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
        $parentCategories = Cache::remember('categories.tree', 3600, function () {
            // logger('DB Query executed for categories');
            
            return Category::whereNull('parent_id')
                ->with('children')
                ->get();
        });

        return CategoryResource::collection($parentCategories);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->with('children')->get();

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
