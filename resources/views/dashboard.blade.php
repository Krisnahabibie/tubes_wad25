@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Dashboard {{ ucfirst(Auth::user()->role) }}</h2>
            <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- 1. Kartu Menu Produk --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-cup-hot-fill" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Menu Produk</h5>
                    <p class="card-text text-muted small">Kelola makanan & minuman.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary w-100 rounded-pill">Lihat Menu</a>
                </div>
            </div>
        </div>

        {{-- 2. Kartu Pesanan Masuk --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-3 text-success">
                        <i class="bi bi-cart-check-fill" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Pesanan Masuk</h5>
                    <p class="card-text text-muted small">Cek orderan dari pelanggan.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-success w-100 rounded-pill">Lihat Pesanan</a>
                </div>
            </div>
        </div>

        {{-- 3. Kartu Manajemen Promo (BARU DITAMBAHKAN) --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-3 text-danger">
                        {{-- Ikon Megaphone / Diskon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-megaphone-fill" viewBox="0 0 16 16">
                            <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-11zm-1 .724c-2.067.95-4.539 1.481-7 1.656v6.237a25.222 25.222 0 0 1 1.088.085c2.053.204 4.038.668 5.912 1.568V3.224v-.001zM2.708 12.555c-1.627-.922-2.708-2.486-2.708-4.305 0-2.453 1.956-4.482 4.608-4.634.256-.015.514-.027.771-.039C5.464 3.566 6 3.553 6 3.553v6.758a25.32 25.32 0 0 1-3.292 2.244z"/>
                        </svg>
                    </div>
                    <h5 class="card-title fw-bold">Kelola Promo</h5>
                    <p class="card-text text-muted small">Atur diskon dan banner depan.</p>
                    <a href="{{ route('promos.index') }}" class="btn btn-danger w-100 rounded-pill">Atur Promo</a>
                </div>
            </div>
        </div>

        {{-- 4. Kartu Kelola Staff (Hanya Manager) --}}
        @if(Auth::user()->role === 'manager')
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kelola Staff</h5>
                    <p class="card-text text-muted small">Tambah atau hapus admin.</p>
                    <a href="{{ route('staff.index') }}" class="btn btn-warning w-100 rounded-pill">Data Staff</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection