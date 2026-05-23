<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! auth()->check() || auth()->user()->role !== $role) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang cukup.');
        }

        return $next($request);
    }
}
