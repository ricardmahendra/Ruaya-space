<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $allowedRoles = array_map('trim', explode('|', $role));

        if (! in_array(auth()->user()->role, $allowedRoles, true)) {
            if (auth()->user()->role === 'kasir') {
                return redirect()->route('kasir.dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang cukup.');
            }

            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang cukup.');
        }

        return $next($request);
    }
}
