@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Riwayat Pesanan Saya</h3>

    @forelse($orders as $order)
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between">
            <span class="fw-bold">{{ $order->invoice_code }}</span>
            
            {{-- Badge Status --}}
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">
                {{ strtoupper($order->status) }}
            </span>
        </div>
        <div class="card-body">
            @foreach($order->orderItems as $item)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <h6 class="mb-0">{{ $item->product->nama_produk }}</h6>
                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price_at_purchase) }}</small>
                </div>

                {{-- TOMBOL REVIEW --}}
                {{-- Logika: Hanya muncul jika order COMPLETED --}}
                @if($order->status == 'completed')
                @php
                    // Cek apakah user sudah pernah review produk ini (TANPA cek order_id)
                $alreadyReviewed = \App\Models\Review::where('user_id', Auth::id())
                        ->where('product_id', $item->product_id)
                        // ->where('order_id', $order->id)  <-- HAPUS ATAU KOMENTARI BARIS INI
                        ->exists();
                @endphp

                @if(!$alreadyReviewed)
                    {{-- Kita hapus parameter order_id dari link agar tidak error di controller nanti --}}
                    <a href="{{ route('reviews.create', ['product_id' => $item->product_id]) }}" 
                    class="btn btn-sm btn-warning">
                        <i class="bi bi-star-fill"></i> Tulis Ulasan
                    </a>
                @else
                    <span class="badge bg-light text-success border">
                        <i class="bi bi-check"></i> Sudah Diulas
                    </span>
                @endif
            @endif
            </div>
            @endforeach
        </div>
    </div>
    @empty
        <div class="alert alert-info">Belum ada riwayat pesanan.</div>
    @endforelse
</div>
@endsection