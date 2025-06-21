@extends('layouts.main')
@section('title', 'Tambah Penyewaan Buku')

@section('content')
<div class="pagetitle">
    <h1>Tambah Penyewaan Buku</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Penyewaan Buku</h5>
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Penyewa</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Pilih Penyewa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- Input Judul Buku dan Pengarang dihapus, diganti dengan Product --}}
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Pilih Buku</label>
                            <select class="form-control" id="product_id" name="product_id" required>
                                <option value="">Pilih Buku dari Daftar Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Penulis: {{ $product->penulis }}, Stok: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
                            @error('author') <div class="text-danger">{{ $message }}</div> @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Buku yang Dipinjam</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" required min="1">
                            @error('quantity') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                            @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="borrowed" {{ old('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                            </select>
                            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection