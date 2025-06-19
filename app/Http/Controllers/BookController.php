<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        ini_set('max_execution_time', 120);

        $limit = min($request->input('per_page', 10), 100);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;
        $search = $request->input('search');
        $currentPage = $page;

        $query = Book::select(
                'books.id',
                'books.title',
                'books.author_id',
                'books.category_id'
            )
            ->selectSub(function($query) {
                $query->from('ratings')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('ratings.book_id', 'books.id');
            }, 'voter')
            ->selectSub(function($query) {
                $query->from('ratings')
                    ->selectRaw('AVG(rating)')
                    ->whereColumn('ratings.book_id', 'books.id');
            }, 'rating_avg');

            if ($search){
                $query->where(function($q) use ($search){
                    $q->whereRaw("MATCH(books.title) AGAINST(? IN BOOLEAN MODE)", [$search])
                    ->orWhereRaw("MATCH(a.name) AGAINST(? IN BOOLEAN MODE)", [$search]);

                });
            }

        // Join authors and categories for name fields, optimize with select only needed columns
        $query->leftJoin('authors as a', 'books.author_id', '=', 'a.id')
            ->leftJoin('categories as c', 'books.category_id', '=', 'c.id')
            ->addSelect('a.name as author_name', 'c.name as category_name');

        $totalBooks = (clone $query)->count();
        $totalPages = ceil($totalBooks / $limit);

        $books = $query->limit($limit)->offset($offset)->get();

        // // Top 10 authors
        // $bookVotes = \DB::table('ratings')
        //     ->where('rating', '>=', 5)
        //     ->select('book_id', DB::raw('COUNT(*) as vote_count'))
        //     ->groupBy('book_id');

        // $topTenAuthors = \DB::table('books')
        //     ->joinSub($bookVotes, 'bv', function($join){
        //         $join->on('books.id', '=', 'bv.book_id');
        //     })
        //     ->join('authors', 'books.author_id', '=', 'authors.id')
        //     ->select('authors.id', 'authors.name', DB::raw('SUM(bv.vote_count) as five_star_votes'))
        //     ->groupBy('authors.id', 'authors.name')
        //     ->orderByDesc('five_star_votes')
        //     ->limit(10)
        //     ->get();


        return view('index', compact('books', 'limit', 'search', 'currentPage', 'totalPages'));
    }

    public function famousAuthors(){
        $topTenAuthors = DB::table('top_rated_books')
            ->join('authors', 'top_rated_books.author_id', '=', 'authors.id')
            ->select('authors.id', 'authors.name', DB::raw('SUM(top_rated_books.five_star_count) as five_star_votes'))
            ->groupBy('authors.id', 'authors.name')
            ->orderByDesc('five_star_votes')
            ->limit(10)
            ->get();


        return view('famous', compact('topTenAuthors'));
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
