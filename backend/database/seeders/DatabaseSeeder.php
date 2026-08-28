<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\BrandSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            AttributeCategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class
        ]);
    }
}
