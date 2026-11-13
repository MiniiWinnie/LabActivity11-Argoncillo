<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthorController extends Controller
{
    public function show(Author $author): View
    {
        $author->load(['posts' => fn (HasMany $query) => $query->latest('published_at')])
            ->loadCount('comments');

        return view('authors.show', compact('author'));
    }
}
