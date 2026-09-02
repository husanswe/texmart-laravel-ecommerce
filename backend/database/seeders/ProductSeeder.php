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
        $samsungBrand = Brand::where('slug', 'samsung')->first();

        $appleBrand = Brand::where('slug', 'apple')->first();
        $ram8phone = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '8')->first();
        $storage128 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '128')->first();
        $colorWhite = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();


        // Fetching attribute values i'll attach
        $ram8 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '8')->first();
        $storage256 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '256')->first();
        $colorBlack = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();
        
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

        $galaxyA55 = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $samsungBrand->id,
            'name' => 'Samsung Galaxy A55',
            'slug' => 'samsung-galaxy-a55',
            'price' => 4299000,
            'description' => 'Samsung Galaxy A55 — zamonaviy dizayn va kuchli kamera.',
        ]);

        ProductVariant::create([
            'product_id' => $galaxyA55->id,
            'name' => '8/256 Black',
            'sku' => 'SAM-A55-8-256-BLK',
            'price' => 4299000,
            'stock' => 20,
        ]);

        ProductVariant::create([
            'product_id' => $galaxyA55->id,
            'name' => '8/256 Blue',
            'sku' => 'SAM-A55-8-256-BLU',
            'price' => 4299000,
            'stock' => 12,
        ]);

        ProductImage::create([
            'product_id' => $galaxyA55->id,
            'image_path' => 'products/samsung-galaxy-a55-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $galaxyA55->attributeValue()->attach([
            $ram8->id,
            $storage256->id,
            $colorBlack->id,
        ]);

        $iphone16 = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $appleBrand->id,
            'name' => 'Apple iPhone 16',
            'slug' => 'apple-iphone-16',
            'price' => 14999000,
            'description' => 'Apple iPhone 16 — eng yangi Apple smartfoni.',
        ]);

        ProductVariant::create([
            'product_id' => $iphone16->id,
            'name' => '8/128 White',
            'sku' => 'APL-IP16-8-128-WHT',
            'price' => 14999000,
            'stock' => 8,
        ]);

        ProductVariant::create([
            'product_id' => $iphone16->id,
            'name' => '8/256 Black',
            'sku' => 'APL-IP16-8-256-BLK',
            'price' => 16999000,
            'stock' => 6,
        ]);

        ProductImage::create([
            'product_id' => $iphone16->id,
            'image_path' => 'products/iphone-16-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $iphone16->attributeValue()->attach([
            $ram8phone->id,
            $storage128->id,
            $colorWhite->id,
        ]);


        // Laptop product creating
        $ram16 = AttributeValue::whereHas('attribte', fn($q) => $q->where('slug', 'ram'))->where('value', '16')->first();
        $storage512 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '512')->first();
        $colorSilver = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '')->first();
        $hpBrand = Brand::where('slug', 'hp')->first();

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

        $hpPavilion = Product::create([
            'category_id' => $laptopsCat->id,
            'brand_id' => $hpBrand->id,
            'name' => 'HP Pavilion 15',
            'slug' => 'hp-pavilion-15',
            'price' => 7499000,
            'description' => 'HP Pavilion 15 — ishbilarmon va talabalar uchun ideal noutbuk.',
        ]);

        ProductVariant::create([
            'product_id' => $hpPavilion->id,
            'name' => '16/512 Silver',
            'sku' => 'HP-PAV15-16-512-SLV',
            'price' => 7499000,
            'stock' => 15,
        ]);

        ProductImage::create([
            'product_id' => $hpPavilion->id,
            'image_path' => 'products/hp-pavilion-15-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $hpPavilion->attributeValue()->attach([
            $ram16->id,
            $storage512->id,
            $colorSilver->id,
        ]);


        // TVs
        
    }
}
