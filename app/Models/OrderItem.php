<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, tapi bagus untuk kepastian)
    protected $table = 'order_items';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_purchase',
    ];

    /**
     * Relasi: Item ini milik satu Order utama
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi: Item ini adalah produk tertentu
     * Kita butuh ini untuk mengambil nama & foto produk di halaman admin/user
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}