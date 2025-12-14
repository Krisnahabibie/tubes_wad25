<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Menggunakan 'category' (Bahasa Inggris) sesuai database
        if ($request->has('category') && $request->category != null) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(10); 

        return view('products.index', compact('products'));
    }
}