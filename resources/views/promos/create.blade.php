@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Buat Promo Baru</h5>
                    {{-- TOMBOL KEMBALI KE DASHBOARD --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light text-danger fw-bold">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>

                <div class="card-body">
    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Gagal Menyimpan!</h4>
                            <p>Silakan periksa inputan berikut:</p>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                @endif

    <form action="{{ route('promos.store') }}" method="POST" enctype="multipart/form-data">
        {{-- ... sisa kode form di bawahnya biarkan sama ... --}}





                    {{-- PENTING: enctype="multipart/form-data" WAJIB ADA UNTUK UPLOAD GAMBAR --}}
                    <form action="{{ route('promos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Promo</label>
                            <input type="text" name="judul_promo" class="form-control" placeholder="Contoh: Diskon Kemerdekaan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Banner</label>
                            <input type="file" name="gambar_promo" class="form-control" required>
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Diskon (%)</label>
                                <input type="number" name="diskon_persen" class="form-control" placeholder="Misal: 50" min="0" max="100" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Promo</label>
                            <textarea name="deskripsi_promo" class="form-control" rows="3" placeholder="Syarat dan ketentuan promo..." required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger fw-bold">Simpan Promo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection