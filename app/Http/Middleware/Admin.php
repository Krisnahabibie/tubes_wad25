<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login DAN role-nya adalah admin
        // Pastikan di database tabel users kolom 'role' isinya 'admin' (huruf kecil)
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Jika bukan admin, lempar error 403 (Forbidden) atau redirect
        return redirect('/')->with('error', 'Kamu tidak punya akses admin!');
    }
}