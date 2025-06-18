<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function index(Request $request){
        $limit = min($request->query('per_page', 10), 100);

        $books = Book::with(['author', 'category', 'ratings'])->paginate($limit);
        return response()->json([
            'status' => 'success',
            'message' => 'Books fetched successfully',
            'data' => $books
        ]);
    }

    public function view(Request $request){
        $limit = min($request->input('per_page', 10), 100);
        $search = $request->input('search');

        $books = Book::select('id', 'title', 'author_id', 'category_id')
        ->with(['author:id,name', 'category:id,name'])
            ->withCount(['ratings as voter' => function ($query) {
                $query->select(\DB::raw('count(*)'));
            }])
            ->withAvg('ratings', 'rating');

        // Get top 10 authors based on number of 5-star ratings
        $bookVotes = \DB::table('ratings')
            ->select('book_id', \DB::raw('COUNT(*) as vote_count'))
            ->where('rating', '>=', 5)
            ->groupBy('book_id');

        // 2. Gabungkan dengan books dan authors untuk hitung total vote author
        $topTenAuthors = \DB::table('books')
            ->joinSub($bookVotes, 'bv', function($join){
                $join->on('books.id', '=', 'bv.book_id');
            })
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->select('authors.id', 'authors.name', \DB::raw('SUM(bv.vote_count) as five_star_votes'))
            ->groupBy('authors.id', 'authors.name')
            ->orderByDesc('five_star_votes')
            ->limit(10)
            ->get();


        if ($search){
            $books->where(function($query) use ($search){
                $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$search])
                    ->orWhereHas('author', function($q) use ($search){
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            });
        }



        $books = $books->paginate($limit)->appends($request->all());

        return view('index', compact('books', 'limit', 'search', 'topTenAuthors'));
    }

    public function store( Request $request){
        $request -> validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::create($request->all());

        return response()->json($book,201);
    }

    public function getBooksByAuthor($id){
        $author = Author::with('books:id,title,author_id')->findOrFail($id);
        return response()->json([
            'books' => $author->books
        ]);
    }

    public function showRatingForm() {
        $authors = Author::select('id', 'name')->get();
        return view('rating.create', compact('authors'));
    }
}
