<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan Form Review
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);

        // Cek apakah user sudah pernah review produk ini (TANPA order_id)
        // Artinya: Satu user hanya bisa review 1x per produk seumur hidup
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product_id)
                                ->first();

        if ($existingReview) {
            return redirect()->route('orders.index')->with('error', 'Anda sudah mengulas produk ini sebelumnya.');
        }

        // Kita kirim data product saja, order tidak perlu
        return view('reviews.create', compact('product'));
    }

    // Menyimpan Review
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5',
            'product_id' => 'required|exists:products,id',
            // 'order_id' dihapus dari validasi
        ]);

        // Cek lagi untuk keamanan ganda sebelum simpan
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->exists();

        if ($existingReview) {
            return redirect()->route('orders.index')->with('error', 'Anda sudah mengulas produk ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            // 'order_id' dihapus dari create
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->route('orders.index')->with('success', 'Terima kasih atas ulasan Anda!');
    }
}