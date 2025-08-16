<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopAuthorController extends Controller
{
     public function index()
    {
        $authors = Author::select('authors.*')
            ->addSelect([
                'voter' => DB::table('ratings')
                    ->join('books', 'books.id', '=', 'ratings.book_id')
                    ->whereColumn('books.author_id', 'authors.id')
                    ->where('ratings.rating', '>', 5)
                    ->select(DB::raw('COUNT(*)'))
            ])
            ->orderByDesc('voter')
            ->limit(10)
            ->get();

        return view('top-authors.index', compact('authors'));
    }
}
