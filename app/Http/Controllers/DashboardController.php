<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Promo;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
            
    }

    public function HomeProduct()
    {
        // Ambil semua produk
        $products = Product::all();
        // Ambil promo yang sedang aktif (opsional, jika tabel promo masih kosong tidak error)
        $promos = Promo::all(); 

        return view('welcome', compact('products', 'promos'));
    }

}
