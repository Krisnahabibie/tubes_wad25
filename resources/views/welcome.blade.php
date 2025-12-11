@extends('layouts.app')

@section('content')

<style>
    .promo-badge { background: rgba(255,255,255,0.85); color: #222; font-weight:700; }
    .promo-card .card-img-overlay { background: linear-gradient(transparent, rgba(0,0,0,0.55)); }
    .product-card img { transition: transform .25s ease; }
    .product-card:hover img { transform: scale(1.03); }
</style>

<div class="container mt-4">
    <div class="p-5 mb-4 rounded-3 shadow-sm border" style="background-image: url('https://source.unsplash.com/1200x400/?cafe,coffee'); background-size: cover; background-position: center;">
        <div class="container-fluid py-5 text-white" style="background: rgba(0,0,0,0.45); border-radius: 10px;">
            <h1 class="display-5 fw-bold">Selamat Datang di Cafe Telkom</h1>
            <p class="col-md-8 fs-4">Nikmati sajian kopi terbaik dan snack lezat ala Lawson dengan harga mahasiswa!</p>
            <a href="#promos" class="btn btn-light btn-lg me-2">Lihat Promo</a>
            <a href="#menu" class="btn btn-primary btn-lg" type="button">Lihat Menu</a>
        </div>
    </div>
</div>

<div class="container" id="promos">
    <h3 class="border-start border-4 border-danger ps-3 mb-4">Promo Pilihan</h3>

    @if(isset($promos) && $promos->count())
        <div id="promoCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($promos as $i => $promo)
                    <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                        <div class="card text-white promo-card">
                            <img src="{{ $promo->gambar_promo ? asset('storage/'.$promo->gambar_promo) : 'https://placehold.co/1200x400?text=Promo' }}" class="d-block w-100" alt="{{ $promo->judul_promo }}" style="height:320px; object-fit:cover;">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <span class="badge promo-badge mb-2">Diskon {{ rtrim(rtrim($promo->diskon_persen, '0'), '.') }}%</span>
                                <h3 class="card-title">{{ $promo->judul_promo }}</h3>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($promo->deskripsi_promo, 120) }}</p>
                                <div>
                                    <a href="#menu" class="btn btn-primary">Gunakan Promo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-3 mb-5">
            @foreach($promos as $promo)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $promo->gambar_promo ? asset('storage/'.$promo->gambar_promo) : 'https://placehold.co/600x300?text=Promo' }}" class="card-img-top" style="height:160px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $promo->judul_promo }}</h5>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($promo->deskripsi_promo, 80) }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-danger">-{{ rtrim(rtrim($promo->diskon_persen, '0'), '.') }}%</span>
                            <a href="#menu" class="btn btn-sm btn-outline-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada promo saat ini. Cek kembali nanti.</div>
    @endif
</div>

<div class="container mt-4" id="menu">
    <h3 class="border-start border-4 border-primary ps-3 mb-4">Menu Pilihan Hari Ini</h3>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/300x200?text=No+Image' }}" 
                         class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">{{ $product->category }}</span>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 50) }}</p>
                        <h5 class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-grid">
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">Belum ada produk yang tersedia saat ini.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection