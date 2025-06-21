@extends('layouts.main')
@section('title', 'Daftar Penyewaan Buku')

@section('content')
<div class="pagetitle">
    <h1>Daftar Penyewaan Buku</h1>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

        {{-- Menampilkan pesan sukses atau error --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Daftar Penyewaan
                </h5>
                <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">
                    Tambah Penyewaan
                </a>

                {{-- Form Pencarian dan Filter --}}
                <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari siswa atau judul buku..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                {{-- Status 'available' mungkin tidak relevan di sini jika ini tabel peminjaman --}}
                                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Penyewa</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop melalui setiap entri penyewaan buku --}}
                        @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->student->name }}</td> {{-- Mengambil nama siswa dari relasi --}}
                            <td>{{ $book->product->name }}</td> {{-- Mengambil judul buku dari relasi Product --}}
                            <td>{{ $book->product->penulis }}</td> {{-- Mengambil pengarang dari relasi Product --}}
                            <td>{{ $book->quantity }}</td>
                            <td>{{ $book->start_date }}</td>
                            <td>{{ $book->end_date }}</td>
                            <td>{{ $book->status }}</td>
                            <td>
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                {{-- Tombol "Kembalikan" hanya muncul jika statusnya 'borrowed' atau 'reserved' --}}
                                @if ($book->status == 'borrowed' || $book->status == 'reserved')
                                    <form action="{{ route('books.return', $book->id) }}" method="POST" style="display:inline;" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai buku ini sebagai dikembalikan?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                    </form>
                                @endif

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
                            <td colspan="9" class="text-center">Tidak ada penyewaan buku tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Link Paginasi --}}
                <div class="d-flex justify-content-center">
                    {{ $books->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</section>
@endsection