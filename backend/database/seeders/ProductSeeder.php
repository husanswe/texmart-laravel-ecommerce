<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch categories and brands by slug/name — never hardcode ids
        $smartphonesCat = Category::where('slug', 'smartfonlar')->first();
        $xiaomiBrand = Brand::where('slug', 'xiaomi')->first();

        // Fetch attribute values you'll attach
        $ram8 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))
            ->where('value', '8')->first();
        $storage256 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))
            ->where('value', '256')->first();
        $colorBlack = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))
            ->where('value', 'Black')->first();
        
        // Creating product
        $redmi = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $xiaomiBrand->id,
            'name' => 'Xiaomi Redmi 15C',
            'slug' => 'xiaomi-redmi-15c',
            'price' => 2399000,
            'description' => 'Xiaomi Redmi 15C - arzon narxdagi smartfon.'
        ]);
    }
}
