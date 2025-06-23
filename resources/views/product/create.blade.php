@extends('layouts.main')
@section('title', 'Tambah Daftar Buku') 

@section('content')
<div class="pagetitle">
    <h1>Tambah Daftar Buku</h1> 
</div>
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Daftar Buku</h5> 
                    {{-- Mengubah action form dari update ke store --}}
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Judul Buku</label>
                            {{-- Menghapus $product->name dari value --}}
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            {{-- Menghapus $product->penulis dari value --}}
                            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis') }}">
                            @error('penulis') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ISBN" class="form-label">ISBN</label>
                            {{-- Menghapus $product->ISBN dari value --}}
                            <input type="text" class="form-control" id="ISBN" name="ISBN" value="{{ old('ISBN') }}">
                            @error('ISBN') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            {{-- Menghapus $product->tahun_terbit dari value, menambahkan default 0 jika perlu --}}
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', 0) }}" min="1900" max="{{ date('Y') }}">
                            @error('tahun_terbit') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>      
                
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Stok</label>
                            {{-- Menghapus $product->quantity dari value, menambahkan default 0 --}}
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" required min="0">
                            @error('quantity') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Buku</button> {{-- Mengubah teks tombol --}}
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection