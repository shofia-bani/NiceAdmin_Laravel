<?php

use App\Http\Controllers\Api\StudentApiController; // Perbaikan ejaan dari Studnet
use App\Http\Controllers\Api\BookApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController; // Pastikan ProductApiController sudah ada

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students', StudentApiController::class); // Perbaikan ejaan
Route::apiResource('books', BookApiController::class);
Route::apiResource('products', ProductApiController::class); // Pastikan ProductApiController sudah ada