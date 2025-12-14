@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Manajemen Promo</h2>
            <p class="text-muted mb-0">Atur diskon dan event spesial.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('promos.create') }}" class="btn btn-primary">
                <i class="bi bi-megaphone-fill"></i> Tambah Promo
            </a>
        </div>
    </div>

    {{-- Alert Sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2"></i> 
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Banner</th>
                            <th class="py-3">Judul Promo</th>
                            <th class="py-3">Periode</th>
                            <th class="py-3">Diskon</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promos as $promo)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                @if($promo->gambar_promo)
                                    <img src="{{ asset('storage/' . $promo->gambar_promo) }}" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ $promo->judul_promo }}</td>
                            <td>
                                <small class="d-block text-muted">Mulai: {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}</small>
                                <small class="d-block text-danger fw-bold">Selesai: {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</small>
                            </td>
                            <td><span class="badge bg-danger fs-6">-{{ $promo->diskon_persen }}%</span></td>
                            <td class="text-end pe-4">
                                <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?');">
                                    {{-- Tombol Edit --}}
                                    {{-- Pastikan route promos.edit dan file edit.blade.php sudah ada jika tombol ini diklik --}}
                                    {{-- <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a> --}}
                                    
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-megaphone fs-1 d-block mb-2 opacity-50"></i>
                                Belum ada promo aktif saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection