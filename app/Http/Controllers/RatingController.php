<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create()
    {
        $authors = Author::orderBy('name')->get();
        return view('ratings.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|between:1,10'
        ]);

        Rating::create([
            'book_id' => $request->book_id,
            'rating' => $request->rating
        ]);

        return redirect()->route('books.index')->with('success', 'Rating submitted successfully!');
    }

    public function getBooks(Author $author)
    {
        return $author->books()->orderBy('title')->get();
    }
}
