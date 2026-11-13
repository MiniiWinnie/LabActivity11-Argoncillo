@extends('app')

@section('title', 'Write a post')

@section('content')
    <div class="mx-auto max-w-3xl px-6 py-10">
        <h1 class="text-3xl font-bold">Write a new post</h1>
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
        <form method="POST" action="{{ route('posts.store') }}" class="mt-6 space-y-4">
            @csrf
            <div><label for="title">Title</label><input id="title" name="title" value="{{ old('title') }}" maxlength="120" class="mt-1 w-full rounded border p-2">@error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror</div>
            <div><label for="category">Category</label><input id="category" name="category" value="{{ old('category') }}" class="mt-1 w-full rounded border p-2">@error('category') <p class="text-sm text-red-600">{{ $message }}</p> @enderror</div>
            <div><label for="body">Message</label><textarea id="body" name="body" rows="6" class="mt-1 w-full rounded border p-2">{{ old('body') }}</textarea>@error('body') <p class="text-sm text-red-600">{{ $message }}</p> @enderror</div>
            <fieldset><legend>Tags</legend><div class="flex flex-wrap gap-3">@foreach ($tags as $tag)<label><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', [])))> {{ $tag->name }}</label>@endforeach</div>@error('tags') <p class="text-sm text-red-600">{{ $message }}</p> @enderror @error('tags.*') <p class="text-sm text-red-600">{{ $message }}</p> @enderror</fieldset>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" @checked(old('is_published'))> Publish immediately</label>
            @error('is_published') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            <button class="rounded bg-teal-700 px-4 py-2 text-white">Publish post</button>
        </form>
    </div>
@endsection
