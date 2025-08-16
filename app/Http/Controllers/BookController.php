<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class BookController extends Controller
{
     public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        
        $query = Book::with(['author', 'category'])
            ->select('books.*')
            ->addSelect([
                'average_rating' => DB::table('ratings')
                    ->selectRaw('AVG(rating)')
                    ->whereColumn('book_id', 'books.id'),
                'voter' => DB::table('ratings')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('book_id', 'books.id')
            ])
            ->orderByDesc('average_rating')
            ->orderByDesc('voter');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('books.title', 'like', "%$search%")
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        // Manually paginate to handle custom select
        $page = $request->input('page', 1);
        $items = $query->get();
        $total = $items->count();
        $books = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('books.index', [
            'books' => $books,
            'perPage' => $perPage,
            'search' => $search
        ]);
    }
}
