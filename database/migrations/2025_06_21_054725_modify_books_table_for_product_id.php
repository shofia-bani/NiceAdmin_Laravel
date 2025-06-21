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
        Schema::table('books', function (Blueprint $table) {
            // Hapus kolom 'title' dan 'author' jika ada
            if (Schema::hasColumn('books', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('books', 'author')) {
                $table->dropColumn('author');
            }

            // Tambahkan product_id sebagai foreign key
            if (!Schema::hasColumn('books', 'product_id')) {
                $table->unsignedBigInteger('product_id')->after('id'); // Posisikan setelah ID
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Hapus foreign key dan kolom product_id
            if (Schema::hasColumn('books', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            // Tambahkan kembali kolom 'title' dan 'author' jika diperlukan untuk rollback
            // $table->string('title')->nullable();
            // $table->string('author')->nullable();
        });
    }
};