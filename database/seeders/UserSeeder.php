<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(8)->create();

        User::create([
            'name' => 'Lola Argoncillo',
            'email' => 'lola.argoncillo@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);
        $kagawad = User::create([
            'name' => 'Kagawad Argoncillo',
            'email' => 'kagawad.argoncillo@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        Author::where('email', $kagawad->email)->firstOrFail()->update([
            'user_id' => $kagawad->id,
        ]);
    }
}
