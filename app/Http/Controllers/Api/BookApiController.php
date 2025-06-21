<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Model untuk entri penyewaan buku
use App\Models\Student; // Model untuk data siswa/penyewa
use App\Models\Product; // Model untuk data produk/buku yang tersedia

class BookController extends Controller
{
    // Opsional: Anda bisa menambahkan middleware di sini untuk otentikasi atau otorisasi
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Contoh: hanya user yang login yang bisa mengakses
    //     // $this->middleware('can:manage-borrowings'); // Contoh middleware otorisasi jika ada
    // }

    /**
     * Menampilkan daftar semua penyewaan buku.
     * Termasuk fitur pencarian dan filter berdasarkan status.
     */
    public function index(Request $request)
    {
        // Eager load relasi 'product' dan 'student' untuk menghindari N+1 query
        $query = Book::with(['product', 'student']);

        // Fitur Pencarian: Berdasarkan nama siswa atau judul buku (nama produk)
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                // Cari di nama siswa melalui relasi 'student'
                $q->whereHas('student', function ($sq) use ($searchTerm) {
                    $sq->where('name', 'like', '%' . $searchTerm . '%');
                })
                // Atau cari di judul buku (kolom 'name' di tabel products) melalui relasi 'product'
                ->orWhereHas('product', function ($pq) use ($searchTerm) {
                    $pq->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        // Fitur Filter: Berdasarkan status penyewaan
        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }

        // Urutkan data, misalnya berdasarkan tanggal pinjam terbaru
        $query->orderBy('start_date', 'desc');

        // Terapkan paginasi, menampilkan 10 data per halaman
        $books = $query->paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * Menampilkan form untuk membuat penyewaan buku baru.
     * Mengirimkan daftar siswa dan produk yang tersedia ke view.
     */
    public function create()
    {
        $students = Student::all(); // Mengambil semua data siswa
        $products = Product::all(); // Mengambil semua data produk (buku yang tersedia)
        return view('books.create', compact('students', 'products'));
    }

    /**
     * Menyimpan penyewaan buku yang baru dibuat ke database.
     * Termasuk validasi dan pengurangan stok produk.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'student_id' => 'required|exists:students,id', // Harus ada dan sesuai dengan ID siswa yang ada
            'product_id' => 'required|exists:products,id', // Harus ada dan sesuai dengan ID produk yang ada
            'quantity' => 'required|integer|min:1', // Jumlah buku yang dipinjam, minimal 1
            'start_date' => 'required|date', // Tanggal pinjam harus format tanggal
            'end_date' => 'required|date|after_or_equal:start_date', // Tanggal kembali harus format tanggal dan setelah/sama dengan tanggal pinjam
            'status' => 'required|in:borrowed,available,reserved', // Status harus salah satu dari yang ditentukan
        ]);

        // Cari produk berdasarkan product_id yang dipilih
        $product = Product::find($request->product_id);

        // Jika produk tidak ditemukan atau stok tidak mencukupi
        if (!$product) {
            return redirect()->back()->withErrors(['product_id' => 'Buku tidak ditemukan.'])->withInput();
        }
        if ($request->quantity > $product->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Jumlah buku yang dipinjam melebihi stok yang tersedia. Stok saat ini: ' . $product->quantity . '.'])->withInput();
        }

        // Buat entri penyewaan baru di tabel 'books'
        Book::create([
            'student_id' => $request->student_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Kurangi stok produk setelah berhasil dipinjam
        $product->decrement('quantity', $request->quantity);

        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail penyewaan buku tertentu.
     */
    public function show(Book $book)
    {
        // Pastikan relasi 'product' dan 'student' dimuat jika belum oleh Route Model Binding
        $book->loadMissing(['product', 'student']);
        return view('books.show', compact('book'));
    }

    /**
     * Menampilkan form untuk mengedit penyewaan buku tertentu.
     * Mengirimkan data penyewaan, siswa, dan produk ke view.
     */
    public function edit(Book $book)
    {
        $students = Student::all();
        $products = Product::all();
        return view('books.edit', compact('book', 'students', 'products'));
    }

    /**
     * Memperbarui penyewaan buku tertentu di database.
     * Termasuk validasi dan penyesuaian stok produk berdasarkan perubahan.
     */
    public function update(Request $request, Book $book)
    {
        // Validasi input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:borrowed,available,reserved,returned', // Tambah 'returned' sebagai status valid
        ]);

        $oldQuantity = $book->quantity;     // Quantity buku yang dipinjam sebelum diupdate
        $oldProductId = $book->product_id; // ID produk buku sebelum diupdate
        $newQuantity = $request->quantity; // Quantity baru dari request
        $newProductId = $request->product_id; // ID produk buku baru dari request
        $newStatus = $request->status;       // Status baru dari request

        $newProduct = Product::find($newProductId); // Ambil objek produk baru

        // Jika produk baru tidak ditemukan
        if (!$newProduct) {
            return redirect()->back()->withErrors(['product_id' => 'Buku baru tidak ditemukan.'])->withInput();
        }

        // Logika penyesuaian stok produk berdasarkan perubahan product_id dan quantity
        if ($oldProductId != $newProductId) {
            // Skenario: Produk buku yang dipinjam diubah
            // 1. Kembalikan stok ke produk lama
            $oldProduct = Product::find($oldProductId);
            if ($oldProduct) {
                $oldProduct->increment('quantity', $oldQuantity);
            }
            // 2. Kurangi stok dari produk baru
            if ($newQuantity > $newProduct->quantity) {
                 return redirect()->back()->withErrors(['quantity' => 'Jumlah buku baru melebihi stok yang tersedia untuk produk baru. Stok: ' . $newProduct->quantity . '.'])->withInput();
            }
            $newProduct->decrement('quantity', $newQuantity);
        } else {
            // Skenario: Produk buku tidak berubah, hanya quantity atau status yang berubah
            $quantityDifference = $newQuantity - $oldQuantity;

            if ($quantityDifference > 0) { // Jika quantity bertambah
                if ($quantityDifference > $newProduct->quantity) {
                    return redirect()->back()->withErrors(['quantity' => 'Penambahan jumlah buku melebihi stok yang tersedia. Stok saat ini: ' . $newProduct->quantity . '.'])->withInput();
                }
                $newProduct->decrement('quantity', $quantityDifference);
            } elseif ($quantityDifference < 0) { // Jika quantity berkurang
                $newProduct->increment('quantity', abs($quantityDifference));
            }
        }

        // Penanganan khusus jika status berubah menjadi 'returned'
        // Penting: Pastikan ini tidak menduplikasi pengembalian stok jika sudah ditangani di atas
        if ($newStatus === 'returned' && $book->status !== 'returned') {
            // Jika buku belum berstatus 'returned' dan diupdate menjadi 'returned'
            // Kita asumsikan stok sudah dikembalikan oleh logika di atas
            // jika tidak, logika berikut bisa ditambahkan:
            // if ($oldProductId == $newProductId) { // Hanya kembalikan jika produk tidak berubah
            //     $newProduct->increment('quantity', $newQuantity); // Jika status berubah menjadi returned, kembalikan semua quantity yang dipinjam
            // }
            // Namun, karena logika update di atas sudah menangani perubahan quantity dan product_id,
            // dan akan mengembalikan selisih atau quantity penuh jika produk diubah,
            // penyesuaian stok saat 'returned' biasanya lebih sederhana di method `returnBook`.
        }

        // Simpan perubahan pada entri penyewaan
        $book->update([
            'student_id' => $request->student_id,
            'product_id' => $newProductId,
            'quantity' => $newQuantity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $newStatus,
        ]);

        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil diperbarui.');
    }

    /**
     * Menandai buku sebagai dikembalikan dan mengembalikan stok ke produk.
     */
    public function returnBook(Book $book)
    {
        // Hanya proses jika statusnya 'borrowed' atau 'reserved' (belum 'returned')
        if ($book->status === 'borrowed' || $book->status === 'reserved') {
            $product = Product::find($book->product_id);
            if ($product) {
                // Kembalikan quantity buku yang dipinjam ke stok produk
                $product->increment('quantity', $book->quantity);
            }
            // Perbarui status penyewaan menjadi 'returned'
            $book->update(['status' => 'returned']);
            return redirect()->route('books.index')->with('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
        }

        return redirect()->back()->with('error', 'Buku ini tidak dalam status dipinjam/dipesan atau sudah dikembalikan.');
    }

    /**
     * Menghapus penyewaan buku dari database.
     * Mengembalikan stok produk jika buku belum berstatus 'returned'.
     */
    public function destroy(Book $book)
    {
        // Hanya kembalikan stok jika status buku belum 'returned'
        // Ini mencegah stok ganda jika buku sudah dikembalikan sebelumnya via returnBook()
        if ($book->status !== 'returned') {
            $product = Product::find($book->product_id);
            if ($product) {
                $product->increment('quantity', $book->quantity);
            }
        }
        // Hapus entri penyewaan dari database
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Penyewaan buku berhasil dihapus.');
    }
}