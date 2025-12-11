<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiviewController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardController;

//tampilan halaman depan
Route::get('/', [App\Http\Controllers\DashboardController::class, 'HomeProduct'])->name('home');

//khusus admin
Route::middleware(['auth', 'Admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('promos', PromoController::class);
    Route::resource('reservasis', ReservasiController::class);

    Route::get( '/keranjang',[KeranjangController::class, 'index'])->name('keranjangs.index');
    Route::post('keranjang/add/{product}', [KeranjangController::class, 'add'])->name('keranjangs.add');
    Route::delete('keranjang/remove/{product}', [KeranjangController::class, 'destroy'])->name('keranjangs.remove');
});
    Route::resource('riviews', RiviewController::class);

//khusus manager
Route::middleware(['auth', 'IsManager'])->group(function () {
    Route::resource('staff', StaffController::class);
});
//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
