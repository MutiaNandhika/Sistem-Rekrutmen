<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterSuccessMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // huruf besar & kecil
                    ->numbers()   // angka
                    ->symbols()   // simbol
            ],[
                'password.*' => 'Password minimal 8 karakter dan harus mengandung huruf besar, angka, dan simbol.',
            ]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pelamar', // DEFAULT ROLE
        ]);

        Mail::to($user->email)->send(new RegisterSuccessMail($user));

        event(new Registered($user));

        Auth::login($user);

        session()->flash('success', 'Registrasi berhasil! Selamat datang');

        return match ($user->role) {
                'admin' => redirect('/admin/dashboard'),
                'hrd' => redirect('/hrd/dashboard'),
                default => redirect('/pelamar/profile'),
            };
    }
}
