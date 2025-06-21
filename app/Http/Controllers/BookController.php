<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Model untuk penyewaan buku
use App\Models\Student;
use App\Models\Product; // Pastikan model Product diimport

class BookController extends Controller
{
    // ... (metode index, show, edit, update, destroy lainnya)

    public function create()
    {
        $students = Student::all();
        $products = Product::all(); // <-- Tambahkan ini untuk mengambil daftar produk
        return view('books.create', compact('students', 'products')); // <-- Kirimkan $products ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'product_id' => 'required|exists:products,id', // <-- Validasi untuk product_id yang baru
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:borrowed,available,reserved',
        ]);

        // Cek stok produk sebelum menyimpan
        $product = Product::find($request->product_id);
        if (!$product || $request->quantity > $product->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Jumlah buku yang dipinjam melebihi stok yang tersedia.'])->withInput();
        }

        Book::create([
            'student_id' => $request->student_id,
            'product_id' => $request->product_id, // <-- Simpan product_id
            'quantity' => $request->quantity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Kurangi stok produk setelah berhasil dipinjam
        $product->decrement('quantity', $request->quantity);

        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil ditambahkan.');
    }

    // ... (pastikan juga metode edit, update, dan destroy disesuaikan
    // untuk menggunakan 'product_id' dan relasi ke Model Product)
}