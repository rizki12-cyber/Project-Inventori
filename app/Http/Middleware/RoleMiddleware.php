<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Tentukan guard berdasarkan role
        $guard = $role === 'admin' ? 'admin' : 'petugas';

        // Cek apakah user login dengan guard yang sesuai
        if (!Auth::guard($guard)->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
