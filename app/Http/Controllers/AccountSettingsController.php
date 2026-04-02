<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountSettingsController extends Controller
{
    public function index()
    {
        return view('settings.account');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],[
                'password.*' => 'Password minimal 8 karakter dan harus mengandung huruf besar, angka, dan simbol.',
            ]
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Kata sandi lama tidak sesuai.');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Kata sandi baru tidak boleh sama dengan kata sandi lama.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

}
