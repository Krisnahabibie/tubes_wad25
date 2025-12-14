<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang; // Model Keranjang
use App\Models\Product;   // Model Produk
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // 1. TAMPILKAN ISI KERANJANG
    public function index()
    {
        // Ambil data keranjang milik user yang sedang login
        $keranjangs = Keranjang::where('user_id', Auth::id())
                        ->with('product') // Eager load relasi produk biar cepat
                        ->get();

        // Hitung total harga
        $totalHarga = 0;
        $totalHarga = $keranjangs->sum(function($item) {
        return $item->product->harga_produk * $item->quantity;
});

        return view('keranjang.index', compact('keranjangs', 'totalHarga'));
    }

    // 2. TAMBAH BARANG KE KERANJANG
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Cek apakah barang ini sudah ada di keranjang user?
        $existingCart = Keranjang::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($existingCart) {
            // Jika sudah ada, tambahkan jumlahnya saja
            $existingCart->quantity += 1;
            $existingCart->save();
        } else {
            // Jika belum ada, buat baris baru
            Keranjang::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    // 3. HAPUS ITEM DARI KERANJANG
    public function destroy($id)
    {
        $item = Keranjang::findOrFail($id);
        
        // Pastikan yang menghapus adalah pemilik keranjang
        if ($item->user_id == Auth::id()) {
            $item->delete();
            return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Tidak memiliki akses.');
    }

    public function updateQuantity(Request $request, $id)
{
    $cart = \App\Models\Keranjang::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
    // Validasi input
    $request->validate([
        'action' => 'required|in:increase,decrease'
    ]);

    if (!$cart->product) {
        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }

    // Logika Tambah/Kurang
    if ($request->action == 'increase') {
        if ($cart->quantity < $cart->product->stok_produk) {
            $cart->increment('quantity');
        } else {
            return response()->json(['error' => 'Stok maksimal tercapai'], 400);
        }
    } else {
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        }
    }

    // Hitung ulang total keranjang user ini
    $allCarts = \App\Models\Keranjang::where('user_id', auth()->id())->get();
    $grandTotal = 0;
    $totalItem = 0;
    
    foreach($allCarts as $c) {
        if($c->product) {
            $grandTotal += $c->product->harga_produk * $c->quantity;
            $totalItem += $c->quantity;
        }
    }

    return response()->json([
        'success' => true,
        'quantity' => $cart->quantity,
        'item_subtotal' => number_format($cart->product->harga_produk * $cart->quantity, 0, ',', '.'),
        'grand_total' => number_format($grandTotal, 0, ',', '.'),
        'total_item' => $totalItem
    ]);
}
}