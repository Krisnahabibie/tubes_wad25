<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang; // Pastikan model Keranjang ada
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // User Checkout dari Keranjang
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $keranjangItems = Keranjang::where('user_id', $user->id)->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung Total
        $totalPrice = 0;
        foreach ($keranjangItems as $item) {
            // Asumsi relasi product di model Keranjang sudah dibuat: public function product()
            $totalPrice += $item->product->harga_produk * $item->quantity;
        }

        // Mulai Transaksi Database (Biar aman kalau error di tengah)
        DB::transaction(function () use ($user, $keranjangItems, $totalPrice) {
            
            // 1. Buat Order
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_code' => 'INV-' . time(), // Contoh INV-17029382
                'total_price' => $totalPrice,
                'status' => 'pending' // Menunggu pembayaran/konfirmasi
            ]);

            // 2. Pindahkan isi Keranjang ke Order Items
            foreach ($keranjangItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->product->harga_produk
                ]);
            }

            // 3. Kosongkan Keranjang
            Keranjang::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');
    }

    // Admin melihat daftar pesanan
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }
}