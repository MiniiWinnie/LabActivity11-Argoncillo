<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $post = Post::where('is_pinned', true)->firstOrFail();
        $lola = User::where('email', 'lola.argoncillo@bulletin.test')->firstOrFail();

        foreach (Post::where('is_published', true)->get() as $publishedPost) {
            $commentCount = $publishedPost->is($post) ? 3 : random_int(0, 5);

            for ($index = 0; $index < $commentCount; $index++) {
                $publishedPost->comments()->create([
                    'user_id' => $publishedPost->is($post) && $index === 0
                        ? $lola->id
                        : User::inRandomOrder()->value('id'),
                    'body' => fake()->sentence(random_int(4, 10)),
                ]);
            }
        }
    }
}
