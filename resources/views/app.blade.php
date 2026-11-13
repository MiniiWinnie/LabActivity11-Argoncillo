<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin – Purok Argoncillo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4" aria-label="Main navigation">
            <a href="{{ route('posts.index') }}" class="text-xl font-bold tracking-tight text-teal-700">Barangay Bulletin – Purok Argoncillo</a>
            <div class="flex items-center gap-6 text-sm font-medium text-slate-600">
                @auth
                    <a href="{{ route('posts.index') }}" class="text-teal-700">Posts</a>
                    @if ($canCreatePosts)
                        <a href="{{ route('posts.create') }}" class="text-teal-700">New post</a>
                    @endif
                    <span>Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-600 hover:text-teal-700">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="text-teal-700">Sign in</a>
                @endguest
            </div>
        </nav>
    </header>

    <main>
        @if (session('status'))
            <div class="mx-auto max-w-7xl px-6 pt-6">
                <p class="rounded border border-teal-200 bg-teal-50 px-4 py-3 text-teal-800">
                    {{ session('status') }}
                </p>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white px-6 py-5 text-center text-sm text-slate-500">
        Barangay Matina Crossing Health Center &middot; Davao City
    </footer>
</body>
</html>
