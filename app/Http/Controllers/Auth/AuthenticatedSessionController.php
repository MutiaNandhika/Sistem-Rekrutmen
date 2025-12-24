<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
{
    // JIKA user diarahkan ke login karena auth middleware
    if (session()->has('url.intended')) {
        session()->flash(
            'message',
            'Silakan login terlebih dahulu untuk melihat detail lowongan.'
        );
    }

    return view('auth.login');
}
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // PRIORITAS: BALIK KE HALAMAN YANG DIMINTA
    if ($request->session()->has('url.intended')) {
        return redirect()->intended();
    }

    // 🔹 LOGIN NORMAL (TANPA DETAIL LOWONGAN)
    $user = $request->user();

    return match ($user->role) {
        'admin' => redirect()->intended('/admin/dashboard'),
        'hrd'   => redirect()->intended('/hrd/dashboard'),
        'pelamar' => redirect()->intended('/pelamar/profile'),
        default => redirect()->intended('/'),
    };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
