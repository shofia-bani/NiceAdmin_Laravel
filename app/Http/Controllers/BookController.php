<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Student;

class BookController extends Controller
{
    public function index() {
        // Mengambil semua buku dengan relasi student
        $books = Book::with('student')->get();
        return view('books.index', compact('books'));
    }

    public function create() {
        // Mengambil semua data siswa untuk dropdown
        $students = Student::all();
        return view('books.create', compact('students'));
    }

    public function store(Request $request) {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:borrowed,available,reserved',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil ditambahkan.');
    }

    public function edit(Book $book) {
        // Mengambil semua data siswa untuk dropdown di form edit
        $students = Student::all();
        return view('books.edit', compact('book', 'students'));
    }

    public function update(Request $request, Book $book) {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:borrowed,available,reserved',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil diperbarui.');
    }

    public function destroy(Book $book) {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil dihapus.');
    }
}