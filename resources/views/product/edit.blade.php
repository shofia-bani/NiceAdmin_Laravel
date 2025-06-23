@extends('layouts.main')
@section('title', 'Edit Produk') 
@section('content')
<div class="pagetitle">
    <h1>Edit Produk</h1>
</div>
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Produk</h5>     
                    <form action="{{ route('product.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $product->penulis) }}">
                            @error('penulis') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ISBN" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="ISBN" name="ISBN" value="{{ old('ISBN', $product->ISBN) }}">
                            @error('ISBN') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $product->tahun_terbit) }}" min="1900" max="{{ date('Y') }}">
                            @error('tahun_terbit') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>      
                
                        <div class="mb-3">
                            {{-- Ubah name dari 'stok' menjadi 'quantity' --}}
                            <label for="quantity" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required min="0">
                            @error('quantity') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection