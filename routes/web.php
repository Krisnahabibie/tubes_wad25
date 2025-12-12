<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiviewController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsManager;

//tampilan halaman depan
Route::get('/', [App\Http\Controllers\DashboardController::class, 'HomeProduct'])->name('landing_page');

//khusus admin
Route::middleware(['auth', \App\Http\Middleware\Admin::class])->group(function () {
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('promos', App\Http\Controllers\PromoController::class);
    Route::resource('reservasis', App\Http\Controllers\ReservasiController::class)->only(['index','update','destroy']);

    Route::get( '/keranjang',[KeranjangController::class, 'index'])->name('keranjangs.index');
    Route::post('keranjang/add/{product}', [KeranjangController::class, 'add'])->name('keranjangs.add');
    Route::delete('keranjang/remove/{product}', [KeranjangController::class, 'destroy'])->name('keranjangs.remove');
});

// Khusus User yang Login (Bisa Belanja & Reservasi)  
  route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjangs.index');
    Route::post('keranjang/add/{product}', [KeranjangController::class, 'add'])->name('keranjangs.add');
    Route::delete('keranjang/remove/{product}', [KeranjangController::class, 'destroy'])->name('keranjangs.remove');

    //USER RESERVASI
    Route::resource('reservasis', ReservasiController::class)->except(['index', 'update', 'destroy']);
    
    Route::resource('riviews', RiviewController::class);
  });


//khusus manager
Route::middleware(['auth', IsManager::class])->group(function () {
    Route::resource('staff', StaffController::class);
});
//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard_user');
