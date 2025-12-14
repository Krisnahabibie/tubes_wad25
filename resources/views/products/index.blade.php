@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Filter Kategori --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0"><i class="bi bi-grid"></i> Menu Kami</h5>
        <div class="btn-group btn-group-sm">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary {{ !request('category') ? 'active' : '' }}">All</a>
            <a href="{{ route('home', ['category' => 'coffee']) }}" class="btn btn-outline-secondary {{ request('category') == 'coffee' ? 'active' : '' }}">Coffee</a>
            <a href="{{ route('home', ['category' => 'food']) }}" class="btn btn-outline-secondary {{ request('category') == 'food' ? 'active' : '' }}">Food</a>
        </div>
    </div>

    {{-- GRID PRODUK (STYLE LAWSON) --}}
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-2 g-md-3">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
                
                {{-- Gambar Kotak --}}
                <div class="position-relative bg-light" style="padding-top: 100%;"> 
                    <img src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://placehold.co/300' }}" 
                         class="position-absolute top-0 start-0 w-100 h-100" 
                         alt="{{ $product->nama_produk }}" 
                         style="object-fit: cover;">
                    
                    {{-- Badge Kategori --}}
                    <span class="position-absolute top-0 start-0 badge bg-dark opacity-75 m-2" style="font-size: 10px;">
                        {{ $product->kategori }}
                    </span>
                </div>

                <div class="card-body p-2 d-flex flex-column">
                    {{-- Nama --}}
                    <h6 class="card-title fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;">
                        {{ $product->nama_produk }}
                    </h6>
                    
                    {{-- Harga --}}
                    <div class="mb-2">
                        <span class="text-primary fw-bold" style="font-size: 14px;">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Tombol Beli --}}
                    <div class="mt-auto">
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-primary w-100 btn-sm fw-bold" style="font-size: 12px;">
                                    + Pesan
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 btn-sm" style="font-size: 12px;">
                                + Beli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <p>Produk tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection