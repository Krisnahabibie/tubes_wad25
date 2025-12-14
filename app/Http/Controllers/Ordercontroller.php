<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * User Checkout dari Keranjang
     * Menggunakan Database Transaction untuk mencegah 'penumpukan' error.
     */
    public function checkout(Request $request)
    {
        $userId = auth()->id();

        // 1. Ambil Data Keranjang
        $keranjangItems = App\Models\Keranjang::where('user_id', $userId)->with('product')->get();


        if ($keranjangItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Mulai Transaksi Database
        // Fungsi ini menjamin: "Semua sukses" atau "Gagal semua".
        // Tidak akan ada kejadian Order masuk tapi Stok tidak berkurang.
        DB::beginTransaction();

        try {
            $totalPrice = 0;
            $orderItemsData = []; // Tampung data untuk disimpan nanti

            // 2. Validasi Stok & Hitung Total (Looping Cek Stok)
            foreach ($keranjangItems as $item) {
                // Ambil data produk terbaru dari DB untuk memastikan stok akurat saat ini
                $product = Product::lockForUpdate()->find($item->product_id); 
                // 'lockForUpdate' mencegah user lain membeli barang yg sama persis di detik yg sama

                if (!$product) {
                    $item->delete();
                }

                // Cek apakah stok cukup?
                if ($product->stok_produk < $item->quantity) {
                    throw new \Exception("Stok " . $product->nama_produk . " tidak mencukupi. Sisa: " . $product->stok_produk);
                }

                // Hitung subtotal
                $totalPrice += $product->harga_produk * $item->quantity;

                // Kurangi Stok Produk SEKARANG (Dalam memori transaksi)
                $product->decrement('stok_produk', $item->quantity);

                // Masukkan ke penampung sementara (JANGAN save ke DB dulu karena Order ID belum ada)
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->harga_produk
                ];

                // Cek jika keranjang jadi kosong setelah filter produk hilang
                if (empty($orderItemsData)) {
                throw new \Exception("Produk di keranjang tidak valid atau sudah dihapus.");
            }

            }

            // 3. Buat Data Order Utama
            $order = Order::create([
                'user_id' => $userId,
                'invoice_code' => 'INV-' . strtoupper(uniqid()), // Generate kode unik
                'total_price' => $totalPrice,
                'status' => 'pending' // Status awal
            ]);

            // 4. Masukkan ke Tabel Order Items
            foreach ($orderItemsData as $data) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price_at_purchase' => $data['price']
                ]);

            
            }

            // 5. Hapus Keranjang User (Bersihkan antrian belanja)
            Keranjang::where('user_id', $userId)->delete();

            // Jika sampai sini tidak ada error, simpan perubahan permanen ke database
            DB::commit();

            return redirect()->route('dashboard_user')->with('success', 'Pesanan berhasil dibuat! Stok produk telah diamankan.');

        } catch (\Exception $e) {
            // Jika ada error (misal stok habis di tengah jalan), batalkan SEMUA perubahan
            DB::rollBack();
            
            // Kembalikan user ke halaman keranjang dengan pesan error
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
    public function index(){
    $user = Auth::user();

    // Jika Admin, ambil semua order
    if ($user->role === 'admin' || $user->role === 'manager') {
        $orders = Order::with(['user', 'orderItems.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders')); // File view khusus admin
    } 
    
    // Jika User Biasa (Customer), ambil order dia saja
    else {
        $orders = Order::with(['orderItems.product'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->paginate(5);
        
        // KITA ARAHKAN KE SINI (File yang akan kita buat)
        return view('orders.index', compact('orders')); 
        }
    }

    // Method untuk Admin mengubah status
    public function updateStatus(Request $request, $id)
    {
        // Pastikan yang akses hanya admin
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

}
