@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- Header Dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-muted mb-0">Mau makan apa hari ini?</p>
        </div>
        
        {{-- BUTTON GROUP: Riwayat & Keranjang --}}
        <div class="d-flex gap-2">
            {{-- Tombol Riwayat Pesanan (BARU) --}}
            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-clock-history me-1"></i> Riwayat Pesanan
            </a>

            {{-- Tombol Keranjang --}}
            <a href="{{ route('keranjangs.index') }}" class="btn btn-primary position-relative">
                <i class="bi bi-cart-fill me-1"></i> Keranjang
                {{-- Badge jumlah item (Optional logic jika ada variable count) --}}
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Kategori (Static Tab) --}}
    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#all">Semua</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#coffee">Coffee</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#food">Food</button>
        </li>
    </ul>

    {{-- Grid Produk --}}
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-3 col-6">
            <div class="card h-100 border-0 shadow-sm product-card">
                {{-- Label Kategori --}}
                <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-light text-dark border shadow-sm">
                        {{ ucfirst($product->kategori_produk) }}
                    </span>
                </div>

                {{-- Gambar Produk --}}
                <img src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://placehold.co/300x200?text=No+Image' }}" 
                     class="card-img-top" 
                     alt="{{ $product->nama_produk }}" 
                     style="height: 200px; object-fit: cover;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-1" style="font-size: 1.1rem;">{{ $product->nama_produk }}</h5>
                    <p class="card-text text-muted small mb-3">
                        {{ Str::limit($product->deskripsi_produk, 45) }}
                    </p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                            <small class="text-secondary" style="font-size: 0.8rem">Stok: {{ $product->stok_produk }}</small>
                        </div>
                        
                        {{-- Form Add to Cart --}}
                        <form action="{{ route('keranjangs.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 rounded-3" 
                                    {{ $product->stok_produk < 1 ? 'disabled' : '' }}>
                                @if($product->stok_produk < 1)
                                    <i class="bi bi-x-circle"></i> Habis
                                @else
                                    <i class="bi bi-cart-plus"></i> Tambah
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p class="mt-2">Belum ada produk yang tersedia saat ini.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Sedikit CSS tambahan agar card rapi */
    .product-card {
        transition: all 0.2s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection