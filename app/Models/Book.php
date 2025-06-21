<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'student_id_number', // Jangan lupa kolom ini dari migrasi sebelumnya
    'major',             // Jangan lupa kolom ini dari migrasi sebelumnya
    'email',             // Tambahkan ini
    'phone',             // Tambahkan ini
];

    // Relasi dengan model Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}