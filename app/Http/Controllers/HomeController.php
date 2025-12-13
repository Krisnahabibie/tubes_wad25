<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\promo;

class HomeController extends Controller
{
    
    public function index()
    {
        // Ini halaman Dashboard User (Bukan halaman depan toko)
        // Mungkin tampilkan history pesanan user di sini?
        $products = Product::all();
        return view('home',compact('products')); 
    }
    
    // Pindahkan logika halaman depan toko ke sini (tanpa Auth)
    public function landingPage()
    {
        $products = \App\Models\Product::all();
        $promos = \App\Models\Promo::all();
        return view('welcome', compact('products', 'promos')); // View 'welcome' adalah tampilan ala Lawson
    }
}