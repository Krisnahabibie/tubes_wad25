@extends('layouts.app')

@section('content')
<style>
    /* Warna Khas Lawson */
    :root {
        --lawson-blue: #003399;
        --lawson-red: #E60012;
        --lawson-bg: #f4f6f9;
    }

    body {
        background-color: var(--lawson-bg);
    }

    /* Header Banner */
    .section-header {
        background-color: var(--lawson-blue);
        color: white;
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0, 51, 153, 0.2);
    }

    /* Card Produk */
    .product-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
        height: 100%; /* Agar tinggi card sama */
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .product-img-wrapper {
        height: 180px;
        overflow: hidden;
        position: relative;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }

    .product-title {
        font-weight: 700;
        color: var(--lawson-blue);
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .product-price {
        color: #333;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .btn-add-cart {
        background-color: var(--lawson-red);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-size: 0.9rem;
        transition: background 0.2s;
        width: 100%;
    }

    .btn-add-cart:hover {
        background-color: #c2000f;
        color: white;
    }
</style>

<div class="container">
    
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="section-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 fw-bold"><i class="fas fa-utensils me-2"></i> Menu Pilihan Hari Ini</h4>
            <small class="text-white-50">Nikmati sajian lezat favoritmu</small>
        </div>
        
        @if(Auth::check() && Auth::user()->role == 'admin') 
            <a href="{{ route('products.create') }}" class="btn btn-light text-primary fw-bold btn-sm">
                <i class="fas fa-plus"></i> Tambah Menu
            </a>
        @endif
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card product-card shadow-sm">
                    <div class="product-img-wrapper">
                        <img src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://via.placeholder.com/300?text=No+Image' }}" 
                             alt="{{ $product->nama_produk }}">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="product-title text-truncate">{{ $product->nama_produk }}</h5>
                        <p class="card-text small text-muted mb-3" style="min-height: 40px;">
                            {{ Str::limit($product->deskripsi_produk, 45) }}
                        </p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="product-price">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                                <small class="text-muted">{{ $product->kategori_produk ?? 'Umum' }}</small>
                            </div>
                            
                            <form action="{{ route('keranjangs.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-add-cart">
                                    <i class="fas fa-shopping-cart me-1"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <h5>Belum ada produk yang tersedia.</h5>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection