@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        
        {{-- Kolom Kiri: Gambar / Info --}}
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="text-center text-md-start">
                <h1 class="fw-bold display-5 text-primary mb-3">Book A Table</h1>
                <p class="lead text-muted mb-4">Nikmati suasana nyaman dan kopi terbaik bersama teman atau keluarga. Amankan kursi Anda sekarang.</p>
                
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&auto=format&fit=crop&q=60" 
                     alt="Cafe Ambience" 
                     class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover"
                     style="height: 400px;">
            </div>
        </div>

        {{-- Kolom Kanan: Form Reservasi --}}
        <div class="col-md-6 offset-md-1">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Alert Sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <h4 class="fw-bold mb-4">Form Reservasi</h4>

                    <form action="{{ route('reservasi.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" class="form-control bg-light border-0 py-2" value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Nomor HP</label>
                                <input type="number" name="no_hp" class="form-control bg-light border-0 py-2" placeholder="0812..." required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Jumlah Orang</label>
                                <input type="number" name="jumlah_orang" class="form-control bg-light border-0 py-2" min="1" max="20" value="2" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Tanggal</label>
                                <input type="date" name="tanggal_reservasi" class="form-control bg-light border-0 py-2" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Jam</label>
                                <input type="time" name="jam_reservasi" class="form-control bg-light border-0 py-2" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted">Catatan Khusus (Opsional)</label>
                            <textarea name="catatan" class="form-control bg-light border-0" rows="3" placeholder="Contoh: Meja dekat jendela, kursi bayi, dll."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">
                            Konfirmasi Reservasi <i class="bi bi-calendar-check ms-2"></i>
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection