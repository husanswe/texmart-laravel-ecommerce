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
        // SMARTPHONES
        'xiaomi-redmi-15c' => [
            'redmi-15c-midnight-black-front.png',
            'redmi-15c-midnight-black-back.png',
            'redmi-15c-midnight-black-sides.png',
            'redmi-15c-midnight-black-top-bottom.png',
        ],
        'samsung-galaxy-a56-5g' => [
            'samsung-galaxy-a56-5g-black-main.png',
            'samsung-galaxy-a56-5g-black-front.png',
            'samsung-galaxy-a56-5g-black-back.png',
        ],
        'apple-iphone-16-pro' => [
            'iphone-16-pro.png',
            'iphone-16-pro-front.png',
            'iphone-16-pro-back.png',
        ],
        'apple-iphone-17-pro-12-256gb' => [
            'iphone-17-pro.png',
            'iphone-17-pro-back-and-side.png',
        ],
        'apple-iphone-18-pro-12-256gb' => [
            'iphone-18-pro.png',
            'iphone-18-pro-front.png',
            'iphone-18-pro-back-and-side.png',
        ],
        'apple-iphone-18-pro-12-512gb' => [
            'iphone-18-pro.png',
            'iphone-18-pro-front.png',
            'iphone-18-pro-back-and-side.png',
        ],

        // LAPTOPS
        'asus-vivobook-15' => [
            'Asus-VivoBook-15-front.png',
            'Asus-VivoBook-15-side.png',
            'Asus-VivoBook-15-back.png',
            'Asus-VivoBook-15-back-side.png',
            'Asus-VivoBook-15-top.png',
        ],
        'hp-pavilion-15' => [
            'hp-pavilion-15-laptop-front.png',
            'hp-pavilion-15-back.png',
        ],

        // TVs
        'samsung-55-4k' => [
            'samsung-tv-55-class-oled-s95h-4k-main.png',
            'samsung-tv-55-class-oled-s95h-4k-front.png',
            'samsung-tv-55-class-oled-s95h-4k-side.png',
        ],
        'artel-32-full-hd' => [
            'Artel-A32KH5000-TV-front.png',
            'Artel-A32KH5000-TV-side.png',
        ],
        'lg-tv-65-8k' => [
            'lg-tv-65-8k-front.png',
            'lg-tv-65-8k-back.png',
            'lg-tv-65-8k-side.png',
        ],

        // FRIDGES
        'bosch-serie-6-french-door-fridge' => [
            'Bosch-Serie-6-French-Door-Fridge-outview.png',
            'Bosch-Serie-6-French-Door-Fridge-opened.png',
        ],
        'samsung-rt32fajbdsa-322l-sovutgichi' => [
            'samsung-fridge-RT32FAJBDSA-322l-main.png',
            'samsung-fridge-RT32FAJBDSA-322l-door-open.png',
        ],
        'sovutgich-artel-hd-430-rwene' => [
            'Fridge-ARTEL-HD-430-RWENE-front.png',
            'Fridge-ARTEL-HD-430-RWENE-main.png',
            'Fridge-ARTEL-HD-430-RWENE-door-open.png',
        ],

        // WASHING MACHINES
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
        'kir-yuvish-mashinasi-hisense-wfqp7012evm' => [
            'hisense-WFQP7012EVM-washing-machine-front.png',
            'hisense-WFQP7012EVM-washing-machine-door-open.png',
            'hisense-WFQP7012EVM-washing-machine-display.png',
        ],

        // AIR CONDITIONERS
        'lg-b18ts-konditsioneri' => [
            'lg-b18ts-ac-front.png',
            'lg-b18ts-ac-top.png',
        ],
        'samsung-ar09txhqasinua-konditsioneri' => [
            'samsung-ac-AR09TXHQASINUA-indoor-unit.png',
            'samsung-ac-AR09TXHQASINUA-outdoor-unit.png',
            'samsung-ac-AR09TXHQASINUA-rc.png',
        ],
        'artel-12hs-s-sir1w12be-konditsioneri' => [
            'Artel-12HS-S-SIR1W12BE-AC.png',
            'Artel-12HS-S-SIR1W12BE-AC-indoor-unit.png',
            'Artel-12HS-S-SIR1W12BE-AC-outdoor-unit.png',
        ],

        // IRONS
        'dazmol-braun-fi3194bk' => [
            'iron-braun-FI3194BK-main.png',
            'iron-braun-FI3194BK-side.png',
            'iron-braun-FI3194BK-back.png',
        ],
        'dazmol-philips-dst8021-30' => [
            'iron-philips-DST8021-30.png',
            'iron-philips-DST8021-30-side.png',
        ],

        // VACUUM CLEANERS
        'chang-yutgich-samsung-vc20m255bwb-uz' => [
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-upside.png',
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-side.png',
            'Samsung-VC20M253BWR-UZ-vacuum-cleaner-left-side.png',
        ],
        'chang-yutgich-lg-vc73189nhts' => [
            'vacuum-cleaner-lg-VC73189NHTS-main.png',
            'vacuum-cleaner-lg-VC73189NHTS-front.png',
            'vacuum-cleaner-lg-VC73189NHTS-side.png',
        ],

        // MICROWAVES
        'mikrotolqinli-pech-lg-ms2042db' => [
            'microwave-oven-lg-MS2042DB-front.png',
            'microwave-oven-lg-MS2042DB-door-open.png',
            'microwave-oven-lg-MS2042DB-touchpad.png',
        ],
        'mikrotolqinli-pech-samsung-me83krw-1kbw' => [
            'microwave-oven-samsung-ME83KRW-1KBW-front.png',
            'microwave-oven-samsung-ME83KRW-1KBW-top.png',
        ],

        // KETTLES
        'elektr-choynak-tefal-ko693110' => [
            'electric-kettle-tefal-KO693110-main.png',
            'electric-kettle-tefal-KO693110-body.png',
            'electric-kettle-tefal-KO693110-lid-open.png',
            'electric-kettle-tefal-KO693110-top.png',
        ],
        'elektr-choynak-braun-wk5205bk' => [
            'electric-kettle-braun-WK5205BK-main.png',
            'electric-kettle-braun-WK5205BK-top.png',
        ],

        // HAIR DRYERS
        'soch-quritgich-polaris-phd-2289ac' => [
            'Hair-Dryer-Polaris-PHD-2289AC-main.png',
            'Hair-Dryer-Polaris-PHD-2289AC-side.png',
        ],
        'soch-quritgich-philips-hps920-00' => [
            'hair-dryer-philips-hps920-00-main.png',
            'hair-dryer-philips-hps920-00-side.png',
            'hair-dryer-philips-hps920-00-back.png',
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