<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    
    // Izinkan kolom ini diisi
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relasi: Keranjang milik satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi: Keranjang milik satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}