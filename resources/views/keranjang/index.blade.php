@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark mb-1">Keranjang Belanja 🛒</h2>
            <p class="text-muted">Periksa item Anda sebelum melanjutkan ke pembayaran.</p>
        </div>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: DAFTAR ITEM --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 40%;">Produk</th>
                                    <th class="text-center py-3">Harga</th>
                                    <th class="text-center py-3" style="width: 20%;">Jumlah</th>
                                    <th class="text-end py-3 pe-4">Subtotal</th>
                                    <th class="py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($keranjangs as $item)
                                    {{-- SAFEGUARD: Cek apakah produk masih ada di database --}}
                                    @if($item->product)
                                    <tr>
                                        {{-- 1. Info Produk --}}
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($item->product->foto_produk)
                                                    <img src="{{ asset('storage/' . $item->product->foto_produk) }}" 
                                                         class="rounded me-3 shadow-sm" 
                                                         style="width: 60px; height: 60px; object-fit: cover;"
                                                         alt="{{ $item->product->nama_produk }}">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center text-white shadow-sm" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark">{{ $item->product->nama_produk }}</h6>
                                                    <small class="text-muted">
                                                        Sisa Stok: <span class="fw-bold">{{ $item->product->stok_produk }}</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 2. Harga Satuan --}}
                                        <td class="text-center">
                                            Rp {{ number_format($item->product->harga_produk, 0, ',', '.') }}
                                        </td>

                                        {{-- 3. Tombol Quantity (+/-) --}}
                                        <td class="text-center">
                                            <div class="input-group input-group-sm justify-content-center" style="width: 120px; margin: 0 auto;">
                                                <button class="btn btn-outline-secondary btn-update" 
                                                        data-id="{{ $item->id }}" 
                                                        data-action="decrease" 
                                                        type="button"><i class="bi bi-dash"></i></button>
                                                
                                                <input type="text" 
                                                       class="form-control text-center bg-white fw-bold" 
                                                       value="{{ $item->quantity }}" 
                                                       id="qty-{{ $item->id }}" 
                                                       readonly>
                                                
                                                <button class="btn btn-outline-secondary btn-update" 
                                                        data-id="{{ $item->id }}" 
                                                        data-action="increase" 
                                                        type="button"><i class="bi bi-plus"></i></button>
                                            </div>
                                        </td>

                                        {{-- 4. Subtotal Item --}}
                                        <td class="text-end pe-4 fw-bold text-primary">
                                            Rp <span id="subtotal-{{ $item->id }}">
                                                {{ number_format($item->product->harga_produk * $item->quantity, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- 5. Tombol Hapus --}}
                                        <td class="text-center pe-3">
                                            <form action="{{ route('keranjangs.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-link text-danger p-0" 
                                                        onclick="return confirm('Hapus produk ini dari keranjang?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                                                <h5 class="mt-3 text-muted">Keranjang Belanja Kosong</h5>
                                                <a href="{{ route('dashboard_user') }}" class="btn btn-primary mt-3 px-4 rounded-pill">
                                                    Mulai Belanja
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('dashboard_user') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Menu Utama
                </a>
            </div>
        </div>

        {{-- BAGIAN KANAN: RINGKASAN ORDER --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Item</span>
                        <span class="fw-bold"><span id="total-item">{{ $keranjangs->sum('quantity') }}</span> pcs</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 align-items-center">
                        <span class="fs-5 fw-bold">Total Harga</span>
                        <span class="fs-4 fw-bold text-primary">
                            Rp <span id="grand-total">{{ number_format($keranjangs->sum(fn($i) => $i->product ? $i->product->harga_produk * $i->quantity : 0), 0, ',', '.') }}</span>
                        </span>
                    </div>

                    @if($keranjangs->count() > 0)
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold shadow-sm text-dark">
                                <i class="bi bi-wallet2 me-2"></i> Checkout Sekarang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100 py-3" disabled>Keranjang Kosong</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT AJAX UNTUK UPDATE KUANTITAS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika tombol +/- diklik
        $('.btn-update').click(function(e) {
            e.preventDefault();
            
            let button = $(this);
            let id = button.data('id');
            let action = button.data('action');
            let inputQty = $('#qty-' + id);

            // Disable button sementara biar gak spam klik
            button.prop('disabled', true);

            $.ajax({
                url: "/keranjang/update/" + id, // Route update quantity
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}', // Wajib untuk keamanan Laravel
                    action: action
                },
                success: function(response) {
                    // Update tampilan angka-angka di halaman
                    inputQty.val(response.quantity); // Input jumlah
                    $('#subtotal-' + id).text(response.item_subtotal); // Subtotal per baris
                    $('#grand-total').text(response.grand_total); // Total harga semua
                    $('#total-item').text(response.total_item); // Total item
                    
                    // Aktifkan tombol lagi
                    button.prop('disabled', false);
                },
                error: function(xhr) {
                    // Tampilkan pesan error jika stok habis atau gagal
                    let errorMsg = xhr.responseJSON.error || 'Terjadi kesalahan sistem';
                    alert(errorMsg);
                    button.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection