<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Http\Resources\AttributeResource;
use Illuminate\Support\Facades\Cache;


class FilterController extends Controller
{
    public function index()
    {
        return Cache::remember('filters.options', 3600, function () {
            $attributes = Attribute::with('values')->get();
            
            return AttributeResource::collection($attributes)->resolve();
        });
    }
}
