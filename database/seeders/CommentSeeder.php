<?php

namespace Database\Seeders;

use App\Models\Comment;
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

            if ($publishedPost->is($post)) {
                Comment::factory()->for($publishedPost)->for($lola, 'user')->create();
                $commentCount--;
            }

            for ($index = 0; $index < $commentCount; $index++) {
                Comment::factory()
                    ->for($publishedPost)
                    ->for(User::inRandomOrder()->firstOrFail(), 'user')
                    ->create();
            }
        }
    }
}
