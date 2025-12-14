@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0 fw-bold">Edit Promo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('promos.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Promo</label>
                            <input type="text" name="judul_promo" class="form-control" value="{{ $promo->judul_promo }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi_promo" class="form-control" rows="3">{{ $promo->deskripsi_promo }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $promo->tanggal_mulai }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="form-control" value="{{ $promo->tanggal_berakhir }}" required>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Besar Diskon (%)</label>
                                <input type="number" name="diskon_persen" class="form-control" value="{{ $promo->diskon_persen }}" step="0.1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ganti Banner (Opsional)</label>
                                <input type="file" name="gambar_promo" class="form-control">
                                @if($promo->gambar_promo)
                                    <small class="text-muted d-block mt-1">Gambar saat ini:</small>
                                    <img src="{{ asset('storage/' . $promo->gambar_promo) }}" height="50" class="rounded">
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('promos.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Update Promo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection