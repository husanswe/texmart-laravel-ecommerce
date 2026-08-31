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
    }
}
