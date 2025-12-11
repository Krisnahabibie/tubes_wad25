<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = product::all();
        return view('products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);
    $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/products/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        product::create($input);

        return redirect()->route('products.index')
            ->with('success', 'produk berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */public function HomeProduct()
     {
        $products = \App\Models\product::all();
        $promos = \App\Models\promo::all();
        return view('welcome', compact('products', 'promos'));
     }
    
}
