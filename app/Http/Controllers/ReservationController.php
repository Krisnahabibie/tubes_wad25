<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Tampilkan Form Reservasi
    public function index()
    {
        return view('reservasi.index');
    }

    // Simpan Data Reservasi
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'tanggal_reservasi' => 'required|date|after_or_equal:today', // Tidak boleh tanggal lampau
            'jam_reservasi' => 'required',
            'jumlah_orang' => 'required|integer|min:1|max:20',
        ]);

        // 2. Simpan ke Database
        Reservasi::create([
            'user_id' => Auth::id(),
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_reservasi' => $request->jam_reservasi,
            'jumlah_orang' => $request->jumlah_orang,
            'catatan' => $request->catatan,
            'status' => 'pending' // Status awal pending
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect()->route('reservasi.index')->with('success', 'Permintaan reservasi berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}