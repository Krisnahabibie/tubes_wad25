<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
protected $table = 'products';
    // --- BAGIAN INI SANGAT PENTING ---
    // Kita mendaftarkan kolom apa saja yang boleh diisi lewat form
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'harga_produk',
        'stok_produk',
        'kategori_produk',
        'foto_produk',
    ];

public function reviews()
{
    return $this->hasMany(Review::class);
}
}