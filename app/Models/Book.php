<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Kolom-kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'student_id',
        'product_id',
        'quantity',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Relasi: Sebuah penyewaan buku dimiliki oleh satu siswa.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi: Sebuah penyewaan buku terkait dengan satu produk (buku fisik).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}