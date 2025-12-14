<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // Pastikan baris ini ada

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // Hapus atau comment baris $redirectTo di bawah ini jika ada
    // protected $redirectTo = '/home'; 

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // TAMBAHKAN FUNGSI INI UNTUK REDIRECT SESUAI ROLE
    public function redirectTo()
    {
        $role = Auth::user()->role;

        if ($role === 'admin' || $role === 'manager') {
            return '/dashboard'; // Admin/Manager ke Dashboard Statistik
        }

        return '/home'; // Customer biasa ke Halaman Belanja
    }
}