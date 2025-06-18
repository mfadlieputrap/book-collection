<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;

Route::get('/books', [BookController::class, 'view'])->name('books.view');
Route::get('/rating', [RatingController::class, 'create'])->name('rating.create');
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
Route::get('/authors/{id}/books', [BookController::class, 'getBooksByAuthor']);

