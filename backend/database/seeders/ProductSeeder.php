<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch categories and brands by slug/name — never hardcode ids
        $smartphonesCat = Category::where('slug', 'smartfonlar')->first();
        $xiaomiBrand = Brand::where('slug', 'xiaomi')->first();
        $laptopsCat = Category::where('slug', 'noutbuklar')->first();
        $asusBrand = Brand::where('slug', 'asus')->first();

        // Fetch attribute values you'll attach
        $ram8 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))
            ->where('value', '8')->first();
        $storage256 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))
            ->where('value', '256')->first();
        $colorBlack = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))
            ->where('value', 'Black')->first();
        
        // Creating product - Phone
        $redmi = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $xiaomiBrand->id,
            'name' => 'Xiaomi Redmi 15C',
            'slug' => 'xiaomi-redmi-15c',
            'price' => 2399000,
            'description' => 'Xiaomi Redmi 15C - arzon narxdagi smartfon.'
        ]);

        ProductVariant::create([
            'product_id' => $redmi->id,
            'name' => '8/256 Midnight Black',
            'sku' => 'RDM15C-8-256-BLK',
            'price' => 2399000,
            'stock' => 20,
        ]);

        ProductImage::create([
            'product_id' => $redmi->id,
            'image_path' => 'products/redmi-15c-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        ProductImage::create([
            'product_id' => $redmi->id,
            'image_path' => 'products/redmi-15c-side.png',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        // 4. Attaching attribute values via pivot
        $redmi->attributeValue()->attach([
            $ram8->id,
            $storage256->id,
            $colorBlack->id
        ]);


        // Laptop product creating
        $ram16 = AttributeValue::whereHas('attribte', fn($q) => $q->where('slug', 'ram'))
            ->where('value', '16')->first();
        $storage512 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))
            ->where('value', '512')->first();
        $colorSilver = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))
            ->where('value', '')->first();

        $asus = Product::Create([
            'category_id' => $laptopsCat->id,
            'brand_id' => $asusBrand->id,
            'name' => 'Asus VivoBook 15',
            'slug' => 'asus-vivobook-15',
            'price' => 8999000,
            'description' => 'Asus VivoBook 15 - zamonaviy noutbuk.'
        ]);

        ProductVariant::Create([
            'product_id' => $asus->id,
            'name' => '16/512 Silver',
            'sku' => 'ASUS-VB15-16-512-SLV',
            'price' => 8999000,
            'stock' => 10,
        ]);

        ProductImage::create([
            'product_id' => $asus->id,
            'image_path' => 'products/asus-vivobook-15-main.png',
            'is_primary' => true,
            'sort_order' => 0
        ]);

        $asus->attributeValue()->attach([
            $ram16->id,
            $storage512->id,
            $colorSilver->id
        ]);
    }
}
