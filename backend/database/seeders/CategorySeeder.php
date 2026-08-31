<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $smartphones = Category::create([
            'name' => 'Smartfonlar',
            'slug' => 'smartfonlar',
            'icon' => 'smartphone',
            'parent_id' => null
        ]);

        $laptops = Category::create([
            'name' => 'Noutbuklar',
            'slug' => 'noutbuklar',
            'icon' => 'laptop',
            'parent_id' => null
        ]);

        $tvs = Category::create([
            'name' => 'Televizor',
            'slug' => 'televizorlar',
            'icon' => 'tv',
            'parent_id' => null
        ]);

        $fridge = Category::create([
            'name' => 'Sovutgichlar',
            'slug' => 'sovutgichlar',
            'icon' => 'refrigerator',
            'parent_id' => null
        ]);

        $washers = Category::create([
            'name' => 'Kir yuvish mashinalari',
            'slug' => 'kir-yuvish-mashinalari',
            'icon' => 'washing-machine',
            'parent_id' => null
        ]);

        $airConditioner = Category::create([
            'name' => 'Konditsioner',
            'slug' => 'air-conditioner',
            'icon' => 'air-conditioner',
            'parent_id' => null
        ]);

        $smallAppliances = Category::create([
            'name' => 'Uy uchun kichik texnika',
            'slug' => 'uy-uchun-kichik-texnika',
            'icon' => 'home',
            'parent_id' => null
        ]);

        Category::create([
            'name' => 'Apple iPhone',
            'slug' => 'apple-iphone',
            'icon' => 'smartphone',
            'parent_id' => $smartphones->id
        ]);

        Category::create([
            'name' => 'Samsung smartfonlar',
            'slug' => 'samsung-smartfonlar',
            'icon' => 'smartphone',
            'parent_id' => $smartphones->id
        ]);

        Category::create([
            'name' => 'Xiaomi smartfonlar',
            'slug' => 'xiaomi-smartfonlar',
            'icon' => 'smartphone',
            'parent_id' => $smartphones->id
        ]);

        Category::create([
            'name' => 'Macbook',
            'slug' => 'macbook',
            'icon' => 'laptop',
            'parent_id' => $laptops->id
        ]);

        Category::create([
            'name' => 'HP Noutbuklar',
            'slug' => 'noutbuk-hp',
            'icon' => 'laptop',
            'parent_id' => $laptops->id
        ]);

        Category::create([
            'name' => 'Asus Noutbuklar',
            'slug' => 'noutbuk-asus',
            'icon' => 'laptop',
            'parent_id' => $laptops->id
        ]);

        Category::create([
            'name' => 'Samsung televizor',
            'slug' => 'samsung-tv',
            'icon' => 'tv',
            'parent_id' => $tvs->id
        ]);

        Category::create([
            'name' => 'LG televizor',
            'slug' => 'lg-tv',
            'icon' => 'tv',
            'parent_id' => $tvs->id
        ]);

        Category::create([
            'name' => 'LG Kir yuvadigan mashina',
            'slug' => 'lg-washing-machine',
            'icon' => 'washing-machine',
            'parent_id' => $washers->id
        ]);

        Category::create([
            'name' => 'LG Sovutgichlari',
            'slug' => 'lg-fridge',
            'icon' => 'fridge',
            'parent_id' => $fridge->id
        ]);

        Category::create([
            'name' => 'LG Konditsioner',
            'slug' => 'lg-air-conditioner',
            'icon' => 'air-conditioner',
            'parent_id' => $airConditioner->id
        ]);

        Category::create([
            'name' => 'Artel Konditsioner',
            'slug' => 'artel-air-conditioner',
            'icon' => 'air-conditioner',
            'parent_id' => $airConditioner->id
        ]);
    }
}
