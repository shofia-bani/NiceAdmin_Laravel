@extends('layouts.main')
@section('title', 'Edit Penyewaan Buku')

@section('content')
<div class="pagetitle">
    <h1>Edit Penyewaan Buku</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Penyewaan Buku</h5>
                    <form action="{{ route('books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Penyewa</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Pilih Penyewa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $book->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Pilih Buku</label>
                            <select class="form-control" id="product_id" name="product_id" required>
                                <option value="">Pilih Buku dari Daftar Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $book->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Penulis: {{ $product->penulis }}, Stok: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Buku yang Dipinjam</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity) }}" required min="1">
                            @error('quantity') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $book->start_date) }}" required>
                            @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $book->end_date) }}" required>
                            @error('end_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Tersedia</option> {{-- Status 'available' mungkin tidak relevan untuk penyewaan --}}
                                <option value="reserved" {{ old('status', $book->status) == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                <option value="returned" {{ old('status', $book->status) == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection