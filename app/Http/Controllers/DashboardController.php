<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. VALIDASI ROLE (Gerbang Keamanan)
        // Jika user bukan Admin dan bukan Manager, lempar ke halaman belanja (User Dashboard)
        if ($user->role !== 'admin' && $user->role !== 'manager') {
            return redirect()->route('dashboard_user');
        }

        // 2. SIAPKAN DATA STATISTIK
        // Admin butuh melihat ringkasan data agar tidak buta informasi
        
        // Hitung total menu yang dijual
        $totalProduk = Product::count();
        
        // Hitung pesanan yang PERLU DIPROSES (status pending/cooking)
        $pesananAktif = Order::whereIn('status', ['pending', 'cooking'])->count();
        
        // Hitung total pendapatan (hanya dari pesanan yang sudah selesai/paid)
        $totalPendapatan = Order::where('status', 'completed')->orWhere('status', 'paid')->sum('total_price');

        // Hitung jumlah staff (Data khusus Manager)
        $totalStaff = User::where('role', 'admin')->count();

        // 3. KIRIM DATA KE VIEW
        return view('dashboard', compact(
            'totalProduk', 
            'pesananAktif', 
            'totalPendapatan', 
            'totalStaff'
        ));
    }
}