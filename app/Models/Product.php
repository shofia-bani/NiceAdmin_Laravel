<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Untuk judul buku
        'penulis',
        'ISBN',
        'tahun_terbit',
        'quantity', // Untuk stok
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
