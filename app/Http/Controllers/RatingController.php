<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// App\Http\Controllers\RatingController.php
use App\Models\Rating;
use App\Models\Author;
use App\Models\Book;

class RatingController extends Controller
{
    

    public function create()
    {
        $authors = Author::all();
        return view('create', compact('authors'));
    }

    public function store(Request $request) {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:10'
        ]);

        Rating::create([
            'book_id' => $request->book_id,
            'rating' => $request->rating
        ]);

        return redirect('/books')->with('success', 'Berhasil menambahkan rating!');
    }


}
