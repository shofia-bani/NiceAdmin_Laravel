<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController; // Jika Anda punya controller terpisah untuk students
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::resource('students', StudentController::class); // Jika Anda memiliki StudentController
Route::resource('books', BookController::class);
Route::resource('product', ProductController::class); // Jika Anda memiliki ProductController
Route::post('/books/{book}/return', [BookController::class, 'returnBook'])->name('books.return');