@extends('layouts.main')
@section('title', 'Tambah Student')

@section('content')
<div class="pagetitle">
    <h1>
        Tambah Student
    </h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Form Tambah Student
                </h5>

                <form action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">
                            {{ $massage }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('emial')
                        <div class="text-danger">
                            {{ $massage }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            Telepon
                        </label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                </form>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection