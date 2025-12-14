<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'judul_promo', 
        'deskripsi_promo', 
        'gambar_promo',
        'tanggal_mulai', 
        'tanggal_berakhir', 
        'diskon_persen'
    ];
}