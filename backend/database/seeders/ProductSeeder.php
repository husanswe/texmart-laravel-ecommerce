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
        $SamsungBrand = Brand::where('slug', 'samsung')->first();

        $appleBrand = Brand::where('slug', 'apple')->first();
        $ram8phone = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '8')->first();
        $storage128 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '128')->first();
        $colorWhite = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();
        
        $tvsCat = Category::where('slug', 'televizorlar')->first();
        $artelBrand = Brand::where('slug', 'artel')->first();
        $lgBrand = Brand::where('slug', 'lg')->first();

        $fridgesCat = Category::where('slug', 'sovutgichlar')->first();
        $boschBrand = Brand::where('slug', 'bosch')->first();

        $washingMachineCat = Category::where('slug', 'kir-yuvish-mashinalari')->first();
        $toshibaBrand = Brand::where('slug', 'toshiba')->first();

        $SmallAppliancesCat = Category::where('slug', 'kichik-maishiy-texnika')->first();
        $BraunBrand = Brand::where('slug', 'braun')->first();
        $PhilipsBrand = Brand::where('slug', 'philips')->first();
        $TefalBrand = Brand::where('slug', 'tefal')->first();
        $PolarisBrand = Brand::where('slug', 'polaris')->first();


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
            'brand_id' => $SamsungBrand->id,
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
        $ram16 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '16')->first();
        $storage512 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '512')->first();
        $colorSilver = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', 'Silver')->first();
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
        $res4k = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', '4K')->first();
        
        $samsungTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $SamsungBrand->id,
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
        $resFHD = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', 'Full HD')->first();

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
        $boschCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '505 L')->first();
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
            $boschCap->id,
            $boschColor->id
        ]);


        // Samsung RT32FAJBDSA (322L) Fridge
        $samsungCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '322 L')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();

        $samsungFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Samsung RT32FAJBDSA 322L Sovutgichi',
            'slug' => 'samsung-rt32fajbdsa-322l-sovutgichi',
            'price' => 7800000,
            'description' => 'Yuqori muzlatish kamerasiga ega xushbichim model'
        ]);

        ProductVariant::create([
            'product_id' => $samsungFridge->id,
            'name' => '322L Stainless Steel',
            'sku' => 'SAMSUNG-FRIDGE-322L',
            'price' => 7800000,
            'stock' => 20
        ]);

        ProductImage::create([
        'product_id' => $samsungFridge->id,
        'image_path' => 'products/samsung-rt32faajbdsa-322l-fridge-main.png',
        'is_primary' => true,
        'sort_order' => 0,
        ]);
        
        $samsungFridge->attributeValue()->attach([
            $samsungCap->id,
            $samsungColor->id
        ]);


        // Sovutgich ARTEL HD 430 RWENE
        $artelCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '322 L')->first();
        $artelColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();

        $artelFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Sovutgich ARTEL HD 430 RWENE',
            'slug' => 'sovutgich-artel-hd-430-rwene',
            'price' => 7600000,
            'description' => 'ARTEL HD 430 RWENE sovutgichi - bu invertorli motorli ikki kamerali sovutgich 
            yuqori energiya samaradorligi (sinfi A+, iste’moli 286 kVt/soat/yil) va atigi 42 dB shovqin 
            darajasida shovqinsiz ishlashni o‘zida mujassam etgan.'
        ]);

        ProductVariant::create([
            'product_id' => $artelFridge->id,
            'name' => '322L Stainless Steel',
            'sku' => 'FRIDGE-ARTEL-HD-430-RWENE',
            'price' => 7600000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $artelFridge->id,
            'image_path' => 'products/artel-hd-430-rwene-fridge-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);
        
        $artelFridge->attributeValue()->attach([
            $artelCap->id,
            $artelColor->id
        ]);


        // WASHING MACHINES. LG F2V3PS6W
        $lgCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '8 kg')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $lgWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $lgBrand->id,
            'name' => 'Kir yuvish mashinasi LG F2V3PS6W',
            'slug' => 'kir-yuvish-mashinasi-lg-f2v3ps6w',
            'price' => 6000000,
            'description' => "LG F2V3PS6W kir yuvish mashinasi - bu yuqori yuvish samaradorligi, 
            foydalanish qulayligi va zamonaviy dizaynni o'zida mujassam etgan uyingiz uchun zamonaviy yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $lgWashingMachine->id,
            'name' => 'Washing Machine LG F2V3PS6W White',
            'sku' => 'WASHING-MACHINE-LG-F2V3PS6W',
            'price' => 6000000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $lgWashingMachine->id,
            'image_path' => 'products/lg-f2v3ps6w-washing-machine-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $lgWashingMachine->attributeValue()->attach([
            $lgCap->id,
            $lgColor->id
        ]);


        // Samsung WW70AG4S21VELD kir yuvish mashinasi
        $samsungCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '7 kg')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $samsungWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Kir yuvish mashinasi Samsung WW70AG4S21VELD',
            'slug' => 'kir-yuvish-mashinasi-samsung-ww70ag4s21veld',
            'price' => 5000000,
            'description' => "Samsung WW70AG4S21VELD kir yuvish mashinasi 7 kg gacha bo‘lgan frontal yuklash 
                va maksimal yuklash imkoniyati bilan kichik oilalar va joy hamda energiyani tejashni istaydigan 
                odamlar uchun ajoyib yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $samsungWashingMachine->id,
            'name' => 'Washing Machine Samsung WW70AG4S21VELD White',
            'sku' => 'WASHING-MACHINE-SAMSUNG-WW70AG4S21VELD',
            'price' => 5000000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $samsungWashingMachine->id,
            'image_path' => 'products/samsung-ww70ag4s21veld-washing-machine-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $samsungWashingMachine->attributeValue()->attach([
            $samsungCap->id,
            $samsungColor->id
        ]);


        // Toshiba TW-BL80A2UZ(WK) kir yuvish mashinasi
        $toshibaCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '7 kg')->first();
        $toshibaColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $toshibaWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $toshibaBrand->id,
            'name' => 'Kir yuvish mashinasi Samsung WW70AG4S21VELD',
            'slug' => 'kir-yuvish-mashinasi-samsung-ww70ag4s21veld',
            'price' => 4500000,
            'description' => "Toshiba TW-BL80A2UZ(WK) kir yuvish mashinasi 7 kg gacha bo‘lgan frontal yuklash 
                va maksimal yuklash imkoniyati bilan kichik oilalar va joy hamda energiyani tejashni istaydigan 
                odamlar uchun ajoyib yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $toshibaWashingMachine->id,
            'name' => 'Washing Machine Toshiba TW-BL80A2UZ(WK) White',
            'sku' => 'WASHING-MACHINE-TOSHIBA-TW-BL80A2UZ(WK)',
            'price' => 4500000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $toshibaWashingMachine->id,
            'image_path' => 'products/toshiba-tw-bl80a2uz(wk)-washing-machine-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $toshibaWashingMachine->attributeValue()->attach([
            $toshibaCap->id,
            $toshibaColor->id
        ]);


        // AIR CONDITIONER LG B18TS
        $lgAcCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '18000 BTU')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $lgAC = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $lgBrand->id,
            'name' => 'LG B18TS Konditsioneri',
            'slug' => 'lg-b18ts-konditsioneri',
            'price' => 12000000,
            'description' => "LG B18TS konditsioneri 18 000 Vt quvvatga ega, u 40-50 kvadrat metrlik xona 
                uchun qulay harorat darajasini ta'minlay oladi. Inverterli kompressor yordamida konditsioner 
                pulni tejaydi va shovqinsiz ishlaydi."
        ]);

        ProductVariant::create([
            'product_id' => $lgAC->id,
            'name' => 'Air Conditioner LG B18TS White',
            'sku' => 'LG-AC-B18TS-WT',
            'price' => 4500000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $lgAC->id,
            'image_path' => 'products/lg-b18ts-konditsioneri-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $lgAC->attributeValue()->attach([
            $lgAcCap->id,
            $lgColor->id
        ]);


        // Konditsioner Samsung AR09TXHQASINUA
        $samsungAcCap = AttributeValue::whereHas('attributes', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '9000 BTU')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $samsungAC = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Samsung AR09TXHQASINUA Konditsioneri',
            'slug' => 'samsung-ar09txhqasinua-konditsioneri',
            'price' => 3050000,
            'description' => "Samsung AR09TXHQASINUA – 25 kvadrat metrgacha bo'lgan 
                xonalarda qulay iqlim yaratish uchun ideal echimdir."
        ]);

        ProductVariant::create([
            'product_id' => $samsungAC->id,
            'name' => 'Air Conditioner Samsung AR09TXHQASINUA White',
            'sku' => 'SMSNG-AC-AR09TXHQASINUA-WT',
            'price' => 3070000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $samsungAC->id,
            'image_path' => 'products/samsung-ar09txhqasinua-konditsioneri-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $samsungAC->attributeValue()->attach([
            $samsungAcCap->id,
            $samsungColor->id
        ]);


        // Artel 12HS S SIR1W12BE Konditsioneri
        $artelAcCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '12000 BTU')->first();
        $artelColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();
        
        $artelAC = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Artel 12HS S SIR1W12BE Konditsioneri',
            'slug' => 'artel-12hs-s-sir1w12be-konditsioneri',
            'price' => 5500000,
            'description' => "Artel 12HS S SIR1W12BE konditsioneri Artel brendi tomonidan ishlab chiqarilgan 
                devorga o'rnatilgan split tizimdir. U displeyga ega, bu uning parametrlarini boshqarish va sozlashni 
                osonlashtiradi. Ushbu konditsioner 12 000 BTU/soat quvvatga ega va barcha fasllarda qulay ichki 
                iqlimni saqlash uchun sovutish va isitish funksiyalarini taklif etadi. Xonada havoni aylantiradigan 
                shamollatish rejimi ham mavjud."
        ]);

        ProductVariant::create([
            'product_id' => $artelAC->id,
            'name' => 'Air Conditioner Artel 12HS S SIR1W12BE White',
            'sku' => 'ARTEL-AC-12HSSSIR1W12BE-WT',
            'price' => 5500000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $artelAC->id,
            'image_path' => 'products/artel-12hs-s-sir1w12be-konditsioneri-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $artelAC->attributeValue()->attach([
            $artelAcCap->id,
            $artelColor->id
        ]);


        // SMALL APPLIANCES. Steam Iron Braun FI3194BK
        $BraunIronPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2400 W')->first();
        $BraunColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Blue')->first(); 
        
        $BraunIron = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $BraunBrand->id,
            'name' => 'Dazmol Braun FI3194BK',
            'slug' => 'dazmol-braun-fi3194bk',
            'price' => 700000,
            'description' => "BraunFI3194BK dazmoli -  tez, samarali va boshqarish juda oson. 
                U FreeGlide3D texnologiyasi bilan jihozlangan bo‘lib, u har qanday to‘siqdan sirpanib 
                o‘tish imkonini beradi. Shuningdek, u ochiq FreeStyleBraun tutqichiga ega. Ushbu ergonomik 
                tutqich maksimal harakat erkinligini va qulay dazmollashni ta’minlaydi. SuperCeramic sizga 
                kamroq harakat bilan tezda ajoyib natijalarga erishish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $BraunBrand->id,
            'name' => 'Dazmol Braun FI3194BK Blue',
            'sku' => 'BRAUN-FI3194-IRON',
            'price' => 700000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $BraunIron->id,
            'image_path' => 'products/dazmol-braun-fi3194bk-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $BraunBrand->attributeValue()->attach([
            $BraunIronPower->id,
            $BraunColor->id
        ]);


        // Dazmol Philips DST8021/30
        $PhilipsIronPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '3000 W')->first();
        $PhilipsColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Purple')->first();
        
        $PhilipsIron = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PhilipsBrand->id,
            'name' => 'Dazmol Philips DST8021/30',
            'slug' => 'dazmol-philips-dst8021/30',
            'price' => 1300000,
            'description' => "3000 W quvvatga ega dazmol tezda ish haroratiga yetib, kiyimlarni 
                parvarish qilishni deyarli darhol boshlash imkonini beradi. 55 g/min gacha bo‘lgan 
                doimiy bug‘ oqimi tolalarni samarali yumshatib, sezilarli burmalar va qurib qolgan 
                joylarni tekislaydi. Kuchaytirilgan bug‘ zarbasi qalin materiallarda yaxshi natija 
                beradi, o‘rnatilgan purkagich esa murakkab qismlarni namlab, kamroq harakat bilan 
                saranjom ko‘rinishga erishishga yordam beradi."
        ]);

        ProductVariant::create([
            'product_id' => $PhilipsBrand->id,
            'name' => 'Dazmol Philips DST8021/30 Purple',
            'sku' => 'PHILIPS-DST8021-IRON',
            'price' => 1300000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $PhilipsIron->id,
            'image_path' => 'products/dazmol-philips-dst8021-30-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $PhilipsBrand->attributeValue()->attach([
            $PhilipsIronPower->id,
            $PhilipsColor->id
        ]);


        // Vacuum Cleaner 
        $SamsungVacuumPower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2000 W')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Dark Blue')->first();
        
        $SamsungVacuum = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Chang Yutgich Samsung VC20M255BWB/UZ',
            'slug' => 'chang-yutgich-samsung-vc20m255bwb-uz',
            'price' => 1600000,
            'description' => "Samsung VC20M255BWB/UZ changyutgichi uy, xonadon yoki ofisda samarali 
                quruq tozalash uchun mo‘ljallangan. 2000 Vt energiya sarfi qurilmaning barqaror ishlashini 
                ta’minlaydi, 460 Vt so‘rish quvvati esa gilam, pol va boshqa yuzalardagi chang, 
                mayda chiqindi, uvog‘ hamda turli iflosliklarni puxta yig‘ishga yordam beradi. 2,5 litr 
                sig‘imli qopcha uni tez-tez almashtirish zaruratini kamaytiradi, bu ayniqsa bir nechta 
                xonani tozalashda qulaydir. Qizil korpus texnikaga yorqin va zamonaviy ko‘rinish bag‘ishlaydi."
        ]);

        ProductVariant::create([
            'product_id' => $SamsungBrand->id,
            'name' => 'Chang Yutgich Samsung VC20M255BWB/UZ',
            'sku' => 'SAMSUNG-VC20M255-VACUUM',
            'price' => 1300000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $SamsungVacuum->id,
            'image_path' => 'products/chang-yutgich-samsung-vc20m255bwb-uz-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $SamsungBrand->attributeValue()->attach([
            $SamsungVacuumPower->id,
            $samsungColor->id
        ]);


        // Chang Yutgich LG VC73189NHTS
        $LGVacuumPower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2000 W')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Dark Blue')->first();
        
        $LGVacuum = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $lgBrand->id,
            'name' => 'Chang Yutgich LG VC73189NHTS',
            'slug' => 'chang-yutgich-lg-vc73189nhts',
            'price' => 1700000,
            'description' => "LG VC73189NHTS 2000 W quvvatga ega, samarali va qulay tozalashni ta'minlovchi zamonaviy qurilma. 
                Kompressor changni siqish texnologiyasi konteynerga ko'proq chang yig'ish imkonini beradi, 
                bu esa yuqori quvvat va oson tozalashni ta'minlaydi. Uzunligi 5 m va diapazoni 8 m bo'lgan 
                quvvat simi doimiy ravishda qayta ulanishni talab qilmasdan xona bo'ylab erkin 
                harakatlanish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $lgBrand->id,
            'name' => 'Chang Yutgich LG VC73189NHTS',
            'sku' => 'LG-VC73189NHTS-VACUUM',
            'price' => 1700000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $LGVacuum->id,
            'image_path' => 'products/chang-yutgich-lg-vc73189nhts-main.png',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $lgBrand->attributeValue()->attach([
            $LGVacuumPower->id,
            $lgColor->id
        ]);


        // MICROWAVE OVEN. LG MS2042DB
        $LgMicrowavePower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '700 W')->first();
        $LgMicrowaveCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '20 L')->first(); 

        $LgMicrowave = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $lgBrand->id,
            'name' => "Mikroto'lqinli Pech LG MS2042DB",
            'slug' => "mikroto'lqinli-pech-lg-ms2042db",
            'price' => 1325000,
            'description' => "LG MS2042DB mikroto'lqinli pech oshxonadagi eng ishonchli yordamchidir. 
                Ovqat tayyorlash jarayonini tezlashtiring va osonlashtiring. Тugmali va sensorli kalitlar 
                qurilmani boshqarishni osonlashtiradi. Ular yordamida vaqt, vazn, quvvat va boshqa 
                funksiyalarini sozlashi mumkin. Siz taomlarni mazali pishirishingiz mumkin. Oddiy va 
                hayratlanarli dizayni mikroto'lqinli pechga chiroyli va zamonaviy ko‘rinish beradi. 
                To‘lqinli uch teng tarqatish tizimi pishirish kamerasini bir tekis isitadi, taomga har 
                tomondan kirib boradi. Buning yordamida taomlar bir xil pishadi. Bardoshli biotermik 
                qoplamani tozalash oson, tirnalmaydi va antibakterial. Ichki makonning yoritilishi 
                mikroto‘lqinli pechdan foydalanishni qulay qiladi. Pechning ish kamerasining foydali 
                hajmi ovqatni pishiradi, isitadi va muzdan tushiradi."
        ]);

        ProductVariant::create([
            'product_id' => $lgBrand->id,
            'name' => "Mikroto'lqinli Pech LG MS2042DB",
            'sku' => 'LG-MS2042DB-MICROWAVE',
            'price' => 1325000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $LgMicrowave->id,
            'image_path' => "products/mikroto'lqinli-pech-lg-ms2042db-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $lgBrand->attributeValue()->attach([
            $LgMicrowavePower->id,
            $LgMicrowaveCap->id
        ]);


        // Mikroto`lqinli Pech Samsung ME83KRW-1KBW
        $SamsungMicrowavePower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '800 W')->first();
        $SamsungMicrowaveCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '23 L')->first(); 

        $SamsungMicrowave = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => "Mikroto'lqinli Pech Samsung ME83KRW-1KBW",
            'slug' => "mikroto'lqinli-pech-lg-ms2042db",
            'price' => 2300000,
            'description' => "Samsung ME83KRW-1KBW mikroto'lqinli pech oshxonadagi eng ishonchli yordamchidir. 
                Ovqat tayyorlash jarayonini tezlashtiring va osonlashtiring. Тugmali va sensorli kalitlar 
                qurilmani boshqarishni osonlashtiradi. Ular yordamida vaqt, vazn, quvvat va boshqa 
                funksiyalarini sozlashi mumkin. Siz taomlarni mazali pishirishingiz mumkin. Oddiy va 
                hayratlanarli dizayni mikroto'lqinli pechga chiroyli va zamonaviy ko‘rinish beradi. 
                To‘lqinli uch teng tarqatish tizimi pishirish kamerasini bir tekis isitadi, taomga har 
                tomondan kirib boradi. Buning yordamida taomlar bir xil pishadi. Bardoshli biotermik 
                qoplamani tozalash oson, tirnalmaydi va antibakterial."
        ]);

        ProductVariant::create([
            'product_id' => $SamsungBrand->id,
            'name' => "Mikroto`lqinli Pech Samsung ME83KRW-1KBW",
            'sku' => 'SAMSUNG-ME83KRW-MICROWAVE',
            'price' => 2300000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $SamsungMicrowave->id,
            'image_path' => "products/mikroto'lqinli-pech-lg-ms2042db-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $SamsungBrand->attributeValue()->attach([
            $SamsungMicrowavePower->id,
            $SamsungMicrowaveCap->id
        ]);


        // ELECTRIC KETTLE. Tefal KO693110
        $TefalKettlePower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '1800 W')->first();
        $TefalKettleCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '1.5 L')->first(); 

        $TefalKettle = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $TefalBrand->id,
            'name' => "Elektr Choynak Tefal KO693110",
            'slug' => "elektr-choynak-tefal-ko693110",
            'price' => 1300000,
            'description' => "Tefal KO693110 elektr choynak yuqori sifatli oziq-ovqat plastmassasidan 
                tayyorlangan. Choynak cho'kindiga qarshi filtr bilan jihozlangan, shuning uchun suvingiz 
                doimo toza bo‘ladi. Choynak korpusining ichki qismida suv darajasi ko‘rsatkichi mavjud. 
                U o‘rnatilgan elektron displey bilan jihozlangan bo‘lib, choynakdagi suv haroratini 
                ko‘rsatadi. Bundan tashqari, 5 ta harorat sozlamalari mavjud. Isitish elementi pastki 
                qismining zanglamaydigan po‘lat ostida yashiringan. Chiroyli dizayn choy va qahvani 
                sevuvchilar uchun ayni muddao. Ushbu model haddan tashqari qizib ketishdan himoya qilingan, 
                qaynaganda, suv yo‘q bo‘lganda yoki choynak stenddan olinganda avtomatik ravishda o‘chiradi."
        ]);

        ProductVariant::create([
            'product_id' => $TefalBrand->id,
            'name' => "Elektr Choynak Tefal KO693110",
            'sku' => 'TEFAL-KO693110-KETTLE',
            'price' => 1300000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $TefalKettle->id,
            'image_path' => "products/elektr-choynak-tefal-ko693110-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $TefalBrand->attributeValue()->attach([
            $TefalKettlePower->id,
            $TefalKettleCap->id
        ]); 


        // Electric Kettle Braun WK5205BK
        $BraunKettlePower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '1800 W')->first();
        $BraunKettleCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '1.5 L')->first(); 

        $BraunKettle = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $BraunBrand->id,
            'name' => "Elektr Choynak Braun WK5205BK",
            'slug' => "elektr-choynak-braun-wk5205bk",
            'price' => 900000,
            'description' => "Braun WK5205BK elektr choynagi — bu texnologik va ishonchli qurilma bo‘lib, 
                uyda yoki ofisda suvni tez qaynatish uchun mo‘ljallangan. 2200 Vt quvvatga ega model 
                suyuqlikni juda qisqa vaqt ichida qaynash holatiga yetkazadi, bu esa ayniqsa ertalabki 
                shoshilinch paytlarda yoki mehmon kutib olayotganda juda qulay. 1.7 litr hajmdagi katta 
                idish bir nechta chashka ichimlikni bir vaqtning o‘zida tayyorlash imkonini beradi, bu esa 
                vaqtingizni tejaydi va kundalik hayotingizda qulaylik yaratadi. Korpusga o‘rnatilgan shaffof 
                ko‘rsatkich orqali suv miqdorini ko‘z bilan baholash mumkin, bu esa to‘lib ketish ehtimolini 
                kamaytiradi. Tashqi qoplamasi metall materialdan yasalgan bo‘lib, u tashqi zarbalarga va yuqori 
                haroratga chidamli. Zamonaviy kumushrang dizayn esa qurilmaga nafis ko‘rinish bag‘ishlaydi 
                va u har qanday oshxona muhitiga mos tushadi."
        ]);

        ProductVariant::create([
            'product_id' => $BraunBrand->id,
            'name' => "Elektr Choynak Braun WK5205BK",
            'sku' => 'BRAUN-WK5205BK-KETTLE',
            'price' => 900000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $BraunKettle->id,
            'image_path' => "products/elektr-choynak-braun-wk5205bk-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $BraunBrand->attributeValue()->attach([
            $BraunKettlePower->id,
            $BraunKettleCap->id
        ]);


        // HAIR DRYER. Polaris PHD 2289AC
        $PolarisDryerPower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2200 W')->first();
        $PolarisDryerColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();

        $PolarisDryer = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PolarisBrand->id,
            'name' => "Soch Quritgich Polaris PHD 2289AC",
            'slug' => "soch-quritgich-polaris-phd-2289ac",
            'price' => 550000,
            'description' => "Polaris PHD 2289AC soch quritgich - 2,2 kW/soat quvvat va 6 harorat 
                rejimiga ega bo‘lib, tez va samarali o‘rnatishni ta’minlaydi. AS motor tufayli 
                fen kuchli havo oqimini hosil qilib, quritish vaqtini qisqartiradi. IonDefence 
                texnologiyasi bilan ionlashtirish statik elektrni kamaytiradi va sochlarni himoya 
                qiladi, ularning tabiiy namligini saqlaydi va tarashni osonlashtiradi."
        ]);

        ProductVariant::create([
            'product_id' => $PolarisBrand->id,
            'name' => "Soch Quritgich Polaris PHD 2289AC",
            'sku' => 'POLARIS-PHD2289AC-HAIRDRYER',
            'price' => 550000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $PolarisDryer->id,
            'image_path' => "products/hair-dryer-polaris-phd-2289ac-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $PolarisBrand->attributeValue()->attach([
            $PolarisDryerPower->id,
            $PolarisDryerColor->id
        ]);


        // Hair Dryer Philips HPS920/00
        $PhilipsDryerPower = AttributeValue::where('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2300 W')->first();
        $PhilipsDryerColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();

        $PolarisDryer = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PhilipsBrand->id,
            'name' => "Soch Quritgich Philips HPS920-00",
            'slug' => "soch-quritgich-philips-hps920-00",
            'price' => 2000000,
            'description' => "Fen Philips HPS920/00 – bu tez quritish va chiroyli soch turmaklash uchun 
                yaratilgan zamonaviy qurilma. 2300 Vt quvvati kuchli havo oqimini ta’minlab, qalin va 
                uzun sochlarni ham osonlik bilan quritishga yordam beradi. Harorat darajasi 210 °C gacha 
                yetadi, bu esa uy sharoitida mustahkam natija olish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $PhilipsBrand->id,
            'name' => "Soch Quritgich Philips HPS920-00",
            'sku' => 'PHILIPS-HPS920-HAIRDRYER',
            'price' => 2000000,
            'stock' => 20
        ]);

        ProductImage::create([
            'product_id' => $PolarisDryer->id,
            'image_path' => "products/hair-dryer-philips-hps920-00-main.png",
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $PhilipsBrand->attributeValue()->attach([
            $PhilipsDryerPower->id,
            $PhilipsDryerColor->id
        ]);
    }
}
