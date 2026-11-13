<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request): View
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function (Builder $query) use ($request): void {
                $query->where('title', 'like', '%'.(string) $request->string('q').'%');
            })
            ->when($request->filled('category'), function (Builder $query) use ($request): void {
                $query->where('category', (string) $request->string('category'));
            })
            ->when($request->filled('tag'), function (Builder $query) use ($request): void {
                $query->whereHas('tags', function (Builder $tagQuery) use ($request): void {
                    $tagQuery->where('tags.id', $request->integer('tag'));
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Post::query()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        $tags = Tag::query()->orderBy('name')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show(Post $post): View
    {
        $post->load(['author', 'tags']);
        $post->load('comments.user');

        abort_unless($post->is_published, 404);

        $post->views++;
        $post->save();

        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        return view('posts.create', ['tags' => Tag::orderBy('name')->get()]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $author = $request->user()->loadMissing('author')->author;
        $data = $request->validated();
        unset($data['tags']);
        $post = $author->posts()->create([
            ...$data,
            'is_published' => true,
            'published_at' => now(),
        ]);
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('posts.show', $post)->with('success', 'Post published.');
    }
}
