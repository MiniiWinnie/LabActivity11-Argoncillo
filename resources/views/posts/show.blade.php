@extends('app')

@section('title', $post->title)

@section('content')
    <article class="mx-auto flex max-w-3xl flex-col gap-6 px-6 py-10">
        <a href="{{ route('posts.index') }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
            &larr; Back to posts
        </a>

        <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-teal-100 px-3 py-1 text-xs font-semibold text-teal-800">
                {{ $post->category }}
            </span>
            @if ($post->is_pinned)
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                    Pinned
                </span>
            @endif
        </div>

        <div class="flex flex-col gap-3">
            <h1 class="text-3xl font-bold text-slate-900">{{ $post->title }}</h1>
            <p class="text-sm text-slate-500">
                Published {{ $post->published_at->format('F j, Y') }} by
                <a href="{{ route('authors.show', $post->author) }}" class="text-teal-700 hover:underline">
                    {{ $post->author->name }}
                </a>
                &middot; {{ $post->views }} views
            </p>
            <div class="flex flex-wrap gap-2">@foreach ($post->tags as $tag)<span class="rounded-full bg-slate-100 px-3 py-1 text-xs">{{ $tag->name }}</span>@endforeach</div>
        </div>

        <div class="whitespace-pre-line leading-7 text-slate-700">{{ $post->body }}</div>

        <section class="border-t border-slate-200 pt-6">
            <h2 class="text-xl font-semibold">Comments</h2>
            @if ($errors->any())
                <div class="mt-4 rounded border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-4 space-y-3">
                @foreach ($post->comments as $comment)
                    <div class="rounded border border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold">{{ $comment->user->name }}</p>
                        <p class="mt-1 text-slate-700">{{ $comment->body }}</p>
                    </div>
                @endforeach
            </div>
            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6">
                    @csrf
                    <label for="body" class="font-medium">Leave a comment</label>
                    <textarea id="body" name="body" rows="3" class="mt-1 w-full rounded border p-2">{{ old('body') }}</textarea>
                    @error('body') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    <button class="mt-2 rounded bg-teal-700 px-4 py-2 text-white">Comment</button>
                </form>
            @else
                <p class="mt-4 text-sm text-slate-600"><a class="text-teal-700" href="{{ route('login') }}">Sign in to comment</a></p>
            @endauth
        </section>
    </article>
@endsection
