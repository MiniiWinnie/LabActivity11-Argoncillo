<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = collect(['Purok Argoncillo', 'Urgent', 'Libre', 'Schedule', 'Health'])
            ->mapWithKeys(fn (string $name): array => [$name => Tag::create(['name' => $name])->id]);
        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();

        foreach (Post::all() as $post) {
            $post->tags()->sync($post->is($pinnedPost)
                ? [$tags['Purok Argoncillo'], $tags['Urgent']]
                : $tags->random(rand(1, 3))->values());
        }
    }
}
