<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // --- BAGIAN INI SANGAT PENTING ---
    // Kita mendaftarkan kolom apa saja yang boleh diisi lewat form
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
    ];
}