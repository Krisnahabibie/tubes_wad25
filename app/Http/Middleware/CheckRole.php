<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('login');
    }

    // Cek apakah role user yang login ada di dalam daftar role yang diizinkan
    if (in_array(auth()->user()->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
}
}
