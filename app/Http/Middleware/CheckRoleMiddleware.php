<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Dapatkan role user yang sedang login
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar $roles yang diizinkan
        // @intelephense-ignore-line
        foreach ($roles as $role) {
            if ($userRole === $role) {
                // Jika cocok (misal: 'admin' === 'admin'), izinkan request
                return $next($request);
            }
        }

        // 4. Jika tidak ada role yang cocok, lempar ke halaman 403 (Forbidden)
        return response('ANDA TIDAK PUNYA AKSES.', 403);
    }
}
