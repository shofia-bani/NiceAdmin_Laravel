<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController; // Jika Anda punya controller terpisah untuk students
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::resource('students', StudentController::class); // Jika Anda memiliki StudentController
Route::resource('books', BookController::class);