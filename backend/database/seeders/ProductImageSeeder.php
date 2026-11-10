<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * product slug => image files inside storage/app/public/product_images/
     * The FIRST file becomes the primary image (shown on product cards).
     */
    private array $images = [
        'xiaomi-redmi-15c' => [
            'redmi-15c-midnight-black-front.png',
            'redmi-15c-midnight-black-back.png',
            'redmi-15c-midnight-black-sides.png',
            'redmi-15c-midnight-black-top-bottom.png',
        ],
        'samsung-galaxy-a55' => [
            'samsung-galaxy-a56-5g-black-main.png',
            'samsung-galaxy-a56-5g-black-front.png',
            'samsung-galaxy-a56-5g-black-back.png',
        ],
        'apple-iphone-16' => [
            'iphone-18-pro.png',
            'iphone-18-pro-front.png',
            'iphone-18-pro-back-and-side.png',
        ],
        'lg-tv-65-8k' => [
            'lg-tv-65-8k-front.png',
            'lg-tv-65-8k-back.png',
            'lg-tv-65-8k-side.png',
        ],
        'samsung-55-4k' => [
            'samsung-tv-55-class-oled-s95h-4k-front.png',
            'samsung-tv-55-class-oled-s95h-4k-main.png',
            'samsung-tv-55-class-oled-s95h-4k-side.png',
        ],
        'samsung-rt32fajbdsa-322l-sovutgichi' => [
            'samsung-fridge-RT32FAJBDSA-322l-main.png',
            'samsung-fridge-RT32FAJBDSA-322l-door-open.png',
        ],
        'kir-yuvish-mashinasi-lg-f2v3ps6w' => [
            'washing-machine-lg-F2V3PS6W-front.png',
            'washing-machine-lg-F2V3PS6W-door-open.png',
            'washing-machine-lg-F2V3PS6W-side.png',
            'washing-machine-lg-F2V3PS6W-back.png',
        ],
        'kir-yuvish-mashinasi-samsung-ww70ag4s21veld' => [
            'washing-machine-samsung-WW70AG4S21VELD-front.png',
            'washing-machine-samsung-WW70AG4S21VELD-door-open.png',
            'washing-machine-samsung-WW70AG4S21VELD-side.png',
            'washing-machine-samsung-WW70AG4S21VELD-back.png',
        ],
        'kir-yuvish-mashinasi-toshiba-tw-bl80a2uz-wk' => [
            'washing-machine-toshiba-TW-BL80A2UZ(WK)-front.png',
            'washing-machine-toshiba-TW-BL80A2UZ(WK)-side.png',
        ],
        'lg-b18ts-konditsioneri' => [
            'lg-b18ts-ac-front.png',
            'lg-b18ts-ac-top.png',
        ],
        'samsung-ar09txhqasinua-konditsioneri' => [
            'samsung-ac-AR09TXHQASINUA-indoor-unit.png',
            'samsung-ac-AR09TXHQASINUA-outdoor-unit.png',
            'samsung-ac-AR09TXHQASINUA-rc.png',
        ],
        'dazmol-braun-fi3194bk' => [
            'iron-braun-FI3194BK-main.png',
            'iron-braun-FI3194BK-side.png',
            'iron-braun-FI3194BK-back.png',
        ],
        'dazmol-philips-dst8021-30' => [
            'iron-philips-DST8021-30.png',
            'iron-philips-DST8021-30-side.png',
        ],
        'chang-yutgich-samsung-vc20m255bwb-uz' => [
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-upside.png',
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-side.png',
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-left-side.png',
        ],
        'mikrotolqinli-pech-lg-ms2042db' => [
            'microwave-oven-lg-MS2042DB-front.png',
            'microwave-oven-lg-MS2042DB-door-open.png',
            'microwave-oven-lg-MS2042DB-touchpad.png',
        ],
        'mikrotolqinli-pech-samsung-me83krw-1kbw' => [
            'microwave-oven-samsung-ME83KRW-1KBW-front.png',
            'microwave-oven-samsung-ME83KRW-1KBW-top.png',
        ],
    ];

    public function run(): void 
    {
        foreach ($this->images as $slug => $imageFiles) 
        {
            $product = Product::where('slug', $slug)->first();

            if (!$product) {
                $this->command->warn("Product not found: {$slug}" );
                continue;
            }

            $product->productImage()->delete();

            foreach ($imageFiles as $index => $fileName) {
                $path = "product_images/{$fileName}";

                if (!Storage::disk('public')->exists($path)) {
                    $this->command->warn("Product image file missing: {$path}");
                    continue;
                } 

                $product->productImage()->create([
                    'image_path' => $path,
                    'is_primary' => ($index === 0),
                    'sort_order' => $index,
                ]);
            }
        }
    }
}