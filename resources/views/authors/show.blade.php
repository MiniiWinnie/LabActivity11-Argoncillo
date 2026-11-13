@extends('app')

@section('title', $author->name)

@section('content')
    <div class="mx-auto flex max-w-4xl flex-col gap-8 px-6 py-10">
        <a href="{{ route('posts.index') }}" class="text-sm font-medium text-teal-700 hover:underline">
            &larr; Back to posts
        </a>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">{{ $author->position }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $author->name }}</h1>
            <p class="mt-2 text-slate-600">{{ $author->email }}</p>
            <p class="mt-4 font-medium text-slate-700">{{ $author->comments_count }} comments received</p>
        </div>

        <section>
            <h2 class="text-2xl font-bold text-slate-900">Posts by {{ $author->name }}</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @forelse ($author->posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm hover:border-teal-500">
                        <h3 class="font-semibold text-slate-900">{{ $post->title }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $post->published_at?->format('F j, Y') ?? 'Draft' }}</p>
                    </a>
                @empty
                    <p class="text-slate-600">No posts yet.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
