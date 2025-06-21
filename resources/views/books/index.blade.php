@extends('layouts.main')
@section('title', 'Daftar Penyewaan Buku')

@section('content')
<div class="pagetitle">
    <h1>Daftar Penyewaan Buku</h1>
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
                    Daftar Penyewaan Buku
                </h5>
                <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">
                    Tambah Penyewaan Buku
                </a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Penyewa</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->student->name }}</td> {{-- Akses nama dari relasi student --}}
                            <td>{{ $book->title }}</td>         {{-- Akses judul langsung dari book --}}
                            <td>{{ $book->author }}</td>        {{-- Akses pengarang langsung dari book --}}
                            <td>{{ $book->quantity }}</td>
                            <td>{{ $book->start_date }}</td>
                            <td>{{ $book->end_date }}</td>
                            <td>{{ $book->status }}</td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                style="display:inline;" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penyewaan ini?')">
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
                            <td colspan="9" class="text-center">Tidak ada data penyewaan buku.</td>
                        </tr>
                        @endforelse
                </table>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection