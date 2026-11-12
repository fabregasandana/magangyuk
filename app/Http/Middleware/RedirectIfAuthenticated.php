<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Alihkan user yang sudah login agar tidak membuka halaman login lagi,
 * dan arahkan tiap role ke dashboard-nya masing-masing.
 */
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            return redirect()->route(dashboardRoute($request->user()->role));
        }

        return $next($request);
    }
}
