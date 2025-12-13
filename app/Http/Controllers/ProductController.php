<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    
    public function index()
    {
        $products = product::all();
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_produk' => 'required', 
            'harga_produk' => 'required|numeric',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kategori_produk' => 'required'
        ]);

        // 2. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('foto_produk')) {
            $imagePath = $request->file('foto_produk')->store('products', 'public');
        }

        // 3. Simpan ke Database
        // Pastikan model Product sudah di-import: use App\Models\Product;
       Product::create([
            'nama_produk'       => $request->nama_produk,
            'deskripsi_produk'  => $request->deskripsi_produk,
            'harga_produk'      => $request->harga_produk,
            'stok_produk'       => $request->stok_produk,
            'kategori_produk'   => $request->kategori_produk,
            'foto_produk'       => $imagePath,
        ]);
        return redirect()->route('products.index')
            ->with('success', 'produk berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function HomeProduct()
     {
        $products = \App\Models\product::all();
        $promos = \App\Models\promo::all();
        return view('welcome', compact('products', 'promos'));
     }
}
