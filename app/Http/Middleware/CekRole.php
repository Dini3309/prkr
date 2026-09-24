<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek login menggunakan SESSION MANUAL aplikasi kamu
        if (!session()->has('username')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil role dari session manual Anda
        $userRole = session('user_role');

        // 3. Cek apakah role di session cocok dengan role yang diizinkan di web.php
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak cocok (misal admin mau buka punya owner dan belum diizinkan), lempar 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
