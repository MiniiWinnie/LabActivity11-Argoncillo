<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kagawad = User::where('email', 'kagawad.argoncillo@bulletin.test')->firstOrFail();

        Author::create([
            'user_id' => $kagawad->id,
            'name' => 'Kapitan Argoncillo',
            'position' => 'Kagawad',
            'email' => 'kagawad.argoncillo@bulletin.test',
        ]);

        Author::factory()->count(4)->create();
    }
}
