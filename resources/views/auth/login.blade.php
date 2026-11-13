@extends('app')

@section('title', 'Sign in')

@section('content')
    <div class="mx-auto max-w-md px-6 py-10">
        <h1 class="text-2xl font-bold">Sign in</h1>
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
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded border p-2">
                @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="mt-1 w-full rounded border p-2">
                @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <button class="rounded bg-teal-700 px-4 py-2 text-white">Sign in</button>
        </form>
    </div>
@endsection
