<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Samsung', 'LG', 'Apple', 'Xiaomi', 'Artel', 'Honor', 'Bosch', 'Phillips'];

        foreach ($brands as $name) {
            Brand::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'logo_path' => 'brands/' . Str::slug($name) . '.png'
            ]);
        }
    }
}
