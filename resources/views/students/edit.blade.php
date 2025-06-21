@extends('layouts.main')
@section('title', 'Edit Student')

@section('content')
<div class="pagetitle">
    <h1>Edit Student</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> 
                    Form Edit Student
                </h5>

                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf {{-- PERBAIKAN TYPO: scrf menjadi csrf --}}
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required> {{-- PERBAIKAN: Tambah name="name" --}}
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required> {{-- PERBAIKAN: Tambah name="email" --}}
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            Telepon
                        </label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" required> {{-- PERBAIKAN: Tambah name="phone" --}}
                        {{-- Catatan: Jika phone bisa nullable, di sini tetap ada 'required'. Sesuaikan dengan validasi di controller. --}}
                    </div>

                    <button type="submit" class="btn btn-success">Update</button> {{-- PERBAIKAN TYPO: succes menjadi success --}}
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection