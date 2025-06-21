<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Student; // Pastikan ini di-import
use Illuminate\Validation\ValidationException; // Import ValidationException

class BookApiController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth:sanctum')->except(['index', 'show']); // Aktifkan jika butuh auth
    // }

    public function index()
    {
        // Eager load relasi student untuk menampilkan nama penyewa
        $books = Book::with('student')->get();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'required|in:borrowed,available,reserved',
            ]);

            $book = Book::create($validatedData);
            return response()->json($book, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Book $book) // Gunakan route model binding
    {
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'required|in:borrowed,available,reserved',
            ]);

            $book->update($validatedData);
            return response()->json($book);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204); // 204 No Content
    }
}