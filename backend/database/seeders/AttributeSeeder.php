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
        $fridges = Category::where('slug', 'sovutgichlar')->first();


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

        foreach (['6.1', '6.5', '6.7', '13', '14', '15', '16', '32', '43', '50', '55', '65', '75'] as $value) {
            AttributeValue::create([
                'attribute_id' => $screenSize->id,
                'value' => $value
            ]);
        }

        $screenSize->category()->attach([$smartphones->id, $laptops->id, $tvs->id]);


        // Resolution
        $resolution = Attribute::create([
            'name' => 'Resolution',
            'slug' => 'resolution',
            'unit' => null
        ]);

        foreach (['Full HD', '4K', '8K'] as $value) {
            AttributeValue::create([
                'attribute_id' => $resolution->id,
                'value' => $value
            ]);
        }

        $resolution->category()->attach([$tvs->id]);


        // Refresh Rate
        $refreshRate = Attribute::create([
            'name' => 'Refresh Rate',
            'slug' => 'refresh-rate',
            'unit' => 'Hz'
        ]);

        foreach (['60', '90', '120', '144'] as $value) {
            AttributeValue::create([
                'attribute_id' => $refreshRate->id,
                'value' => $value
            ]);
        }

        $refreshRate->category()->attach([$smartphones->id, $laptops->id, $tvs->id]);


        // Screen Type
        $screenType = Attribute::create([
            'name' => 'Screen Type',
            'slug' => 'screen-type',
            'unit' => null
        ]);

        foreach (['LED', 'OLED', 'QLED', 'IPS'] as $value) {
            AttributeValue::create([
                'attribute_id' => $screenType->id,
                'value' => $value
            ]);
        }

        $screenType->category()->attach([$tvs->id]);


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


        // Capacity
        $capacity = Attribute::create([
            'name' => 'Capacity',
            'slug' => 'capacity',
            'unit' => 'L'
        ]);

        foreach (['200', '250', '300', '350'] as $value) {
            AttributeValue::create([
                'attribute_id' => $capacity->id,
                'value' => $value
            ]);
        }

        $capacity->category()->attach([$fridges->id]);
    }
}
