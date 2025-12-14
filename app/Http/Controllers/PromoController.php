<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    // Menampilkan Daftar Promo (Admin)
    public function index()
    {
        $promos = Promo::all();
        return view('promos.index', compact('promos'));
    }

    // Menampilkan Form Tambah Promo
    public function create()
    {
        return view('promos.create');
    }

    // MENYIMPAN DATA KE DATABASE (PENTING!)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'judul_promo' => 'required|string|max:255|unique:promos',
            'deskripsi_promo' => 'required',
            'gambar_promo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 2. Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('gambar_promo')) {
            $imagePath = $request->file('gambar_promo')->store('promos', 'public');
        }

        // 3. Simpan ke Database
        Promo::create([
            'judul_promo' => $request->judul_promo,
            'deskripsi_promo' => $request->deskripsi_promo,
            'gambar_promo' => $imagePath,
            'diskon_persen' => $request->diskon_persen,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        // 4. Redirect kembali ke halaman Index Promo
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dibuat!');
    }

    // Menghapus Promo
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        
        // Hapus file gambar jika ada
        if ($promo->gambar_promo) {
            Storage::disk('public')->delete($promo->gambar_promo);
        }

        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}