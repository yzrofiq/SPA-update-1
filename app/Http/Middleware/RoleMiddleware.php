<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Mengecek apakah pengguna sudah login dan role-nya sesuai
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);  // Jika role sesuai, lanjutkan request
        }

        // Jika role tidak sesuai, arahkan ke halaman yang diinginkan (bisa home atau halaman lain)
        return redirect('/'); // Arahkan ke halaman utama
    }
}
