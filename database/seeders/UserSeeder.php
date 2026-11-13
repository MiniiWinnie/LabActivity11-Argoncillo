<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(8)->create();

        User::create([
            'name' => 'Lola Argoncillo',
            'email' => 'lola.argoncillo@bulletin.test',
            'password' => 'bulletin2026',
        ]);
        User::create([
            'name' => 'Kagawad Argoncillo',
            'email' => 'kagawad.argoncillo@bulletin.test',
            'password' => 'bulletin2026',
        ]);
    }
}
