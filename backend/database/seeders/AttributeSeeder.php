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
    }
}
