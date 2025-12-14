@extends('layouts.app')

@section('content')
{{-- Custom CSS untuk Hero Section --}}
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 51, 153, 0.8), rgba(0, 51, 153, 0.6)), url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        border-radius: 0 0 50px 50px; /* Lengkungan bawah */
    }
    .promo-card {
        transition: transform 0.3s;
        border: none;
        overflow: hidden;
    }
    .promo-card:hover {
        transform: translateY(-10px);
    }
    .section-title {
        color: #003399; /* Lawson Blue */
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

{{-- 1. HERO SECTION --}}
<div class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Nikmati Kopi & Snack Favoritmu</h1>
        <p class="lead mb-4">Cafe Telkom x Lawson Style. Harga Mahasiswa, Rasa Juara.</p>
        @guest
            <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-5 fw-bold rounded-pill shadow">
                Pesan Sekarang <i class="bi bi-arrow-right"></i>
            </a>
            <div class="mt-3 text-white-50">
                Belum punya akun? <a href="{{ route('register') }}" class="text-white text-decoration-underline">Daftar disini</a>
            </div>
        @else
            <a href="{{ route('dashboard_user') }}" class="btn btn-light btn-lg px-5 fw-bold rounded-pill shadow text-primary">
                Lihat Menu <i class="bi bi-shop"></i>
            </a>
        @endguest
    </div>
</div>

<div class="container">
    
   {{-- 2. SECTION PROMO --}}
    <div class="container py-5" id="promos">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-dark border-start border-4 border-danger ps-3">Promo Spesial Hari Ini</h2>
                <p class="text-muted ms-3">Dapatkan penawaran terbaik khusus untuk mahasiswa!</p>
            </div>
        </div>
    
        <div class="row g-4">
            @forelse($promos as $promo)
                <div class="col-md-4 mb-4">
                    <div class="card promo-card shadow-sm h-100 border-0">
                        {{-- Badge Diskon --}}
                        <div class="position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 m-3 rounded-pill fw-bold shadow-sm" style="z-index: 2;">
                            Hemat {{ $promo->diskon_persen }}%
                        </div>
    
                        {{-- Gambar Promo --}}
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            @if($promo->gambar_promo)
                                <img src="{{ asset('storage/' . $promo->gambar_promo) }}" class="w-100 h-100 object-fit-cover" alt="{{ $promo->judul_promo }}">
                            @else
                                <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                        </div>
    
                        <div class="card-body">
                            <small class="text-danger fw-bold">
                                <i class="bi bi-calendar-event me-1"></i> 
                                Berlaku sampai {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}
                            </small>
                            <h5 class="card-title fw-bold mt-2">{{ $promo->judul_promo }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($promo->deskripsi_promo, 80) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan Jika Tidak Ada Promo --}}
                <div class="col-12 text-center py-5 bg-light rounded-3">
                    <h5 class="text-muted">Belum ada promo aktif saat ini.</h5>
                    <p class="text-muted small">Nantikan update selanjutnya ya!</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- 3. SECTION MENU PREVIEW (Hanya Tampilan) --}}
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h3 class="section-title">☕ Menu Terfavorit</h3>
            <p class="text-muted">Login untuk mulai memesan menu lezat ini.</p>
        </div>

        @foreach($products->take(4) as $product) 
        {{-- Kita hanya ambil 4 produk teratas sebagai preview --}}
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://placehold.co/300x200?text=Menu+Cafe' }}" 
                     class="card-img-top rounded-top" 
                     alt="{{ $product->nama_produk }}"
                     style="height: 180px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-dark mb-1">{{ $product->nama_produk }}</h5>
                    <p class="text-primary fw-bold mb-3">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</p>
                    
                    {{-- Tombol diarahkan ke Login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                        Login untuk Membeli
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 4. INFO SECTION --}}
    <div class="row py-5 border-top">
        <div class="col-md-4 text-center mb-3">
            <i class="bi bi-clock-history fs-1 text-primary"></i>
            <h5 class="fw-bold mt-2">Buka Setiap Hari</h5>
            <p class="text-muted">08:00 - 22:00 WIB</p>
        </div>
        <div class="col-md-4 text-center mb-3">
            <i class="bi bi-geo-alt-fill fs-1 text-danger"></i>
            <h5 class="fw-bold mt-2">Lokasi Strategis</h5>
            <p class="text-muted">Gedung Telyu Coffee, Bandung</p>
        </div>
        <div class="col-md-4 text-center mb-3">
            <i class="bi bi-wifi fs-1 text-success"></i>
            <h5 class="fw-bold mt-2">Free WiFi</h5>
            <p class="text-muted">Koneksi kencang untuk nugas</p>
        </div>
    </div>

</div>
@endsection