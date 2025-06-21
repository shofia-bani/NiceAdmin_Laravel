@extends('layouts.main')
@section('title', 'Daftar Produk')

@section('content')
<div class="pagetitle">
    <h1>Daftar Produk</h1>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Daftar Produk
                </h5>
                <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">
                    Tambah Produk
                </a>    
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>ISBN</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td> {{-- Ini adalah judul buku --}}
                            <td>{{ $product->penulis }}</td>
                            <td>{{ $product->ISBN }}</td>
                            <td>{{ $product->tahun_terbit }}</td>
                            <td>{{ $product->quantity }}</td> {{-- Ini adalah stok --}}
                            <td>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                style="display:inline;" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada produk tersedia.</td> {{-- Sesuaikan colspan --}}
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection