<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


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
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di folder: storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan ke Database
        // Pastikan model Product sudah di-import: use App\Models\Product;
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'image' => $imagePath,
        ]);
        return redirect()->route('home')
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
