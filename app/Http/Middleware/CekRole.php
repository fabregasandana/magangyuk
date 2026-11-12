<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pastikan user login memiliki salah satu role yang diizinkan.
 *
 * Dipakai sebagai alias 'role:admin,pembimbing,peserta' di route group.
 * Sekaligus menolak akun berstatus nonaktif.
 */
class CekRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->isAktif()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
            ]);
        }

        if ($roles !== [] && ! in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
