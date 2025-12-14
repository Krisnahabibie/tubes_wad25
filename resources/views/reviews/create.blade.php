@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Header Warna --}}
                <div class="card-header bg-primary text-white text-center py-4 position-relative">
                    <h4 class="fw-bold mb-0">Bagaimana pesanan Anda?</h4>
                    <p class="mb-0 opacity-75">Berikan penilaian untuk meningkatkan kualitas kami</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    {{-- Preview Produk --}}
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <img src="{{ $product->foto_produk ? asset('storage/' . $product->foto_produk) : 'https://placehold.co/100x100' }}" 
                             alt="{{ $product->nama_produk }}" 
                             class="rounded-3 me-3 object-fit-cover" 
                             style="width: 70px; height: 70px;">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $product->nama_produk }}</h6>
                            <p class="text-muted small mb-0">{{ Str::limit($product->deskripsi_produk, 60) }}</p>
                        </div>
                    </div>

                    {{-- Form Review --}}
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Input Rating Bintang Interaktif --}}
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold text-muted small text-uppercase">Rating Kepuasan</label>
                            
                            <div class="star-rating d-flex justify-content-center flex-row-reverse gap-2">
                                {{-- Urutan input dibalik agar CSS sibling selector berfungsi (5 ke 1) --}}
                                <input type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="Sempurna"><i class="bi bi-star-fill display-6"></i></label>
                                
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="Sangat Baik"><i class="bi bi-star-fill display-6"></i></label>
                                
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="Cukup"><i class="bi bi-star-fill display-6"></i></label>
                                
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="Buruk"><i class="bi bi-star-fill display-6"></i></label>
                                
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="Sangat Buruk"><i class="bi bi-star-fill display-6"></i></label>
                            </div>
                            <div class="mt-2 text-warning fw-bold" id="rating-text">Pilih Bintang</div>
                        </div>

                        {{-- Input Komentar --}}
                        <div class="mb-4">
                            <label for="komentar" class="form-label fw-bold text-muted small text-uppercase">Ulasan Anda</label>
                            <textarea name="komentar" id="komentar" rows="4" 
                                      class="form-control bg-light border-0" 
                                      placeholder="Ceritakan pengalaman Anda tentang rasa, penyajian, atau pengiriman..." required></textarea>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm transition-btn">
                            Kirim Ulasan <i class="bi bi-send-fill ms-2"></i>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS HALAMAN INI --}}
<style>
    /* Sembunyikan Radio Button Asli */
    .star-rating input {
        display: none;
    }

    /* Style Bintang Default (Abu-abu) */
    .star-rating label {
        color: #e4e5e9;
        cursor: pointer;
        transition: color 0.2s;
    }

    /* Style Bintang saat di-Hover (Kuning) */
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107; /* Warna Kuning Bootstrap */
    }

    /* Style Bintang saat Dipilih (Tetap Kuning) */
    .star-rating input:checked ~ label {
        color: #ffc107;
    }

    /* Animasi Sedikit saat hover */
    .star-rating label:hover {
        transform: scale(1.1);
    }

    /* Tombol Transisi */
    .transition-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important;
    }
</style>

{{-- SCRIPT SEDERHANA UNTUK UBAH TEKS RATING --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ratingText = document.getElementById('rating-text');
        const stars = document.querySelectorAll('.star-rating input');
        
        const messages = {
            1: "Sangat Buruk 😞",
            2: "Buruk 🙁",
            3: "Cukup 😐",
            4: "Enak! 😋",
            5: "Sempurna! 😍"
        };

        stars.forEach(star => {
            star.addEventListener('change', function() {
                ratingText.textContent = messages[this.value];
            });
        });
    });
</script>
@endsection