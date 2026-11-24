<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     * Proteksi Keamanan: Jika belum login atau bukan role 'user', tolak dengan HTTP 403 Forbidden.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(403, 'Akses Ditolak: Anda belum login! Area ini terproteksi ketat dan hanya dapat diakses oleh Pengguna (User) yang telah login.');
        }

        if (Auth::user()->role !== 'user') {
            abort(403, 'Akses Ditolak: Anda masuk sebagai Administrator. Area ini khusus untuk akun Pengguna (Pelanggan).');
        }

        return $next($request);
    }
}
