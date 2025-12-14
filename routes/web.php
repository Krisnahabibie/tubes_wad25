<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (Landing Page)
// 1. HALAMAN DEPAN
Route::get('/', function () {
    // Kita kirim array kosong [] bernama 'promos' agar welcome.blade.php tidak error
    return view('welcome', ['promos' => []]);
});

// 2. HALAMAN MENU (Produk)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 3. AUTH (Login/Register)
Auth::routes();

// 4. DASHBOARD & HOME
// Kita buat dua jalur ke HomeController agar 'dashboard_user' tidak error
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard_user'); // <-- INI BARIS PENYELAMAT ERROR ANDA

// 5. FITUR MEMBER (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // Order / Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Reservasi
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    
    // Review
    Route::get('/reviews/{product_id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});