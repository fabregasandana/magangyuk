<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** Percobaan login maksimal per menit sebelum dikunci sementara. */
    private const MAX_PERCOBAAN = 5;
    private const DETIK_KUNCI = 60;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $this->pastikanTidakTerkunci($request);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request), self::DETIK_KUNCI);

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        if (! $user->isAktif()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));
        $request->session()->regenerate();

        ActivityLog::catat('login', 'Masuk ke sistem sebagai ' . $user->role, $user);

        // Setiap role punya dashboard sendiri; intended() tetap dihormati.
        return redirect()->intended(dashboardPath($user->role));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            ActivityLog::catat('logout', 'Keluar dari sistem', $user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->string('email')) . '|' . $request->ip()
        );
    }

    private function pastikanTidakTerkunci(Request $request): void
    {
        $key = $this->throttleKey($request);

        if (! RateLimiter::tooManyAttempts($key, self::MAX_PERCOBAAN)) {
            return;
        }

        $detik = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$detik} detik.",
        ]);
    }
}
