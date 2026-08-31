<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test Admin',
            'phone_number' => '+998' . fake()->randomElement(['90', '91','93','94','95','97','99','88','33']) . fake()->numerify('#######'),
            'email' => 'husanswe1@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => true 
        ]);

        User::factory()->count(4)->create([
            'is_admin' => false
        ]);
    }
}
