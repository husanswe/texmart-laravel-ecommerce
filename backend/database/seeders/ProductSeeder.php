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

        $tvsCat = Category::where('slug', 'televizorlar')->first();
        $artelBrand = Brand::where('slug', 'artel')->first();
        $lgBrand = Brand::where('slug', 'lg')->first();


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


        // TVs. SAMSUNG TV
        $screen55 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '55')->first();
        $res4k = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', '55')->first();
        
        $samsungTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $samsungBrand->id,
            'name' => "Samsung 55 4K",
            'slug' => 'samsung-55-4k',
            'price' => 5999000,
            'desciption' => 'Samsung 55 dyumli 4K Ultra HD Smart televizor.' 
        ]);

        ProductVariant::create([
            'product_id' => $samsungTV->id,
            'name' => '55" Black',
            'sku' => 'SAM-TV-55-4K-BLK',
            'price' => 5999000,
            'stock' => 18
        ]);

        ProductImage::create([
            'product_id' => $samsungTV->id,
            'image_path' => 'products/samsung-55-tv-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $samsungTV->attributeValue()->attach([
            $screen55->id,
            $res4k->id
        ]);

        // ARTEL TV
        $screen32 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '32')->first();
        $resFHD = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', 'FHD')->first();

        $artelTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Artel 32 Full HD',
            'slug' => 'artel-32-full-hd',
            'price' => 1550000,
            'description' => 'Hamyonbop sifatli SMART televizor'
        ]);

        ProductVariant::create([
            'product_id' => $artelTV->id,
            'name' => '32" Black',
            'sku' => 'ARTL-TV-32-FHD-BLK',
            'price' => 1550000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $artelTV->id,
            'image_path' => 'products/artel-32-tv-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $artelTV->attributeValue()->attach([
            $screen32->id,
            $resFHD->id
        ]);

        // LG TV
        $screen65 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '65')->first();
        $res8K = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', '8K')->first();

        $lgTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $lgBrand->id,
            'name' => 'LG TV 65 8K',
            'slug' => 'lg-tv-65-8k',
            'price' => 28000000,
            'description' => '8K LG SMART TV'
        ]);

        ProductVariant::create([
            'product_id' => $lgTV->id,
            'name' => '65" Black',
            'sku' => 'LG-TV-65-8K-BLK',
            'price' => 28000000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $lgTV->id,
            'image_path' => 'products/lg-65-tv-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $lgTV->attributeValue()->attach([
            $screen65->id,
            $res8K->id
        ]);


        //  FRIDGES.Bosch Fridge
        $boschCapacity = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '505 L')->first();
        $boschColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();
        
        $boschFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $boschBrand->id,
            'name' => 'Bosch Serie 6 French Door Fridge',
            'slug' => 'bosch-serie-6-french-door-fridge',
            'price' => 18500000,
            'description' => 'Bosch Serie 6 NoFrost French Door Refrigerator with VitaFresh Pro'
        ]);

        ProductVariant::create([
            'product_id' => $boschFridge->id,
            'name' => '505L Stainless Steel',
            'sku' => 'BOSCH-FRIDGE-505L-SS',
            'price' => 18500000,
            'stock' => 12
        ]);

        ProductImage::create([
        'product_id' => $boschFridge->id,
        'image_path' => 'products/bosch-serie-6-fridge-main.png',
        'is_primary' => true,
        'sort_order' => 0,
        ]);
        
        $boschFridge->attributeValue()->attach([
            $boschCapacity->id,
            $boschColor->id
        ]);
    }
}
