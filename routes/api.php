<?php

use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\BookApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students', StudentApiController::class);
Route::apiResource('books', BookApiController::class);
Route::apiResource('products', ProductApiController::class);