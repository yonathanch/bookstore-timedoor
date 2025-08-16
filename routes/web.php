<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TopAuthorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

// Books routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Top authors routes
Route::get('/top-authors', [TopAuthorController::class, 'index'])->name('top-authors.index');

// Rating routes
Route::get('/input-rating', [RatingController::class, 'create'])->name('ratings.create');
Route::post('/input-rating', [RatingController::class, 'store'])->name('ratings.store');
Route::get('/authors/{author}/books', [RatingController::class, 'getBooks'])->name('authors.books');
