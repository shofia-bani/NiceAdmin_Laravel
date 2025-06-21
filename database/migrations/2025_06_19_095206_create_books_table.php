<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) { // Nama 'books' ini bisa diganti 'borrowings'
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Foreign key ke tabel students
            $table->string('title');   // Judul buku (disimpan di sini karena tidak ada tabel product terpisah)
            $table->string('author');  // Pengarang buku (disimpan di sini karena tidak ada tabel product terpisah)
            $table->integer('quantity');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['borrowed', 'available', 'reserved'])->default('borrowed'); // Default 'borrowed' saat baru dipinjam
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};