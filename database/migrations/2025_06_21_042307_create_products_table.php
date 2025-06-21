<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Kolom-kolom untuk detail buku
            $table->string('name')->comment('Judul Buku'); // Untuk "judul buku"
            $table->string('penulis')->nullable();
            $table->string('ISBN', 13)->unique()->nullable(); // ISBN biasanya 10 atau 13 karakter, dan harus unik
            $table->integer('tahun_terbit')->nullable();
            $table->integer('quantity')->default(0)->comment('Jumlah stok buku'); // Untuk "quantity" atau "stok"

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};