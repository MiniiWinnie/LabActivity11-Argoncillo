<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulletinRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_resident_without_author_is_forbidden_from_creating_a_post(): void
    {
        $resident = User::factory()->create();

        $this->actingAs($resident)
            ->post(route('posts.store'), [])
            ->assertForbidden();

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_authenticated_user_can_comment_and_filter_posts_by_tag(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $tag = Tag::create(['name' => 'Urgent']);
        $post = Post::factory()->for($author)->create(['title' => 'Tagged announcement']);
        $post->tags()->sync([$tag->id]);

        $this->actingAs($user)
            ->post(route('comments.store', $post), ['body' => 'Useful update'])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Useful update',
        ]);

        $this->get(route('posts.index', ['tag' => $tag->id]))
            ->assertOk()
            ->assertSee('Tagged announcement');

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('Useful update');
    }

    public function test_user_with_author_profile_can_create_a_tagged_post(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create(['user_id' => $user->id]);
        $tag = Tag::create(['name' => 'Schedule']);

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'New schedule',
                'category' => 'Announcement',
                'body' => 'The schedule is now available.',
                'tags' => [$tag->id],
            ])
            ->assertRedirect();

        $post = Post::where('title', 'New schedule')->firstOrFail();
        $this->assertSame($author->id, $post->author_id);
        $this->assertTrue($post->tags->contains($tag));
    }

    public function test_short_comment_uses_the_purok_custom_message(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $post), ['body' => 'ab'])
            ->assertSessionHasErrors([
                'body' => 'Purok Argoncillo comments need at least 3 characters.',
            ]);
    }

    public function test_author_page_displays_comments_received_through_posts(): void
    {
        $author = Author::factory()->create();
        $post = Post::factory()->for($author)->create();
        $user = User::factory()->create();
        Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'A received comment',
        ]);

        $this->get(route('authors.show', $author))
            ->assertOk()
            ->assertSee('1 comments received');
    }
}
