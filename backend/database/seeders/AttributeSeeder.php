<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $smartphones = Category::where('slug', 'smartfonlar')->first();
        $laptops = Category::where('slug', 'noutbuklar')->first();
        $tvs = Category::where('slug', 'televizorlar')->first();
        $fridge = Category::where('slug', 'sovutgichlar')->first();


        // RAM
        $ram = Attribute::create([
            'name' => 'RAM',
            'slug' => 'ram', 
            'unit' => 'GB'
        ]);

        foreach (['4', '6', '8', '12', '16'] as $value) {
            AttributeValue::create([
                'attribute_id' => $ram->id,
                'value' => $value
            ]);
        }

        $ram->category()->attach([$smartphones->id, $laptops->id]);


        // Storage 
        $storage = Attribute::create([
            'name' => 'Storage',
            'slug' => 'storage',
            'unit' => 'GB'
        ]);

        foreach (['64', '128', '256', '512'] as $value) {
            AttributeValue::create([
                'attribute_id' => $storage->id,
                'value' => $value
            ]);
        }

        $storage->category()->attach([$smartphones->id, $laptops->id]);


        // Screen Size
        $screenSize = Attribute::create([
            'name' => 'Screen size',
            'slug' => 'screen-size',
            'unit' => 'inch'
        ]);

        foreach (['6.1', '6.5', '6.7', '55', '65'] as $value) {
            AttributeValue::create([
                'attribute_id' => $screenSize->id,
                'value' => $value
            ]);
        }

        $screenSize->category()->attach([$smartphones->id, $tvs->id]);


        // Battery 
        $battery = Attribute::create([
            'name' => 'Battery',
            'slug' => 'battery',
            'unit' => 'mAh'
        ]);

        foreach (['3000', '4000', '5000'] as $value) {
            AttributeValue::create([
                'attribute_id' => $battery->id,
                'value' => $value
            ]);
        }

        $battery->category()->attach([$smartphones->id]);


        // Color 
        $color = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'unit' => null
        ]);

        foreach (['Black', 'White', 'Blue', 'Silver'] as $value) {
            AttributeValue::create([
                'attribute_id' => $color->id,
                'value' => $value
            ]);
        }

        $color->category()->attach([$smartphones->id, $laptops->id, $tvs->id]);
    }
}
