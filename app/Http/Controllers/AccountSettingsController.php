<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSettingsController extends Controller
{
    public function index()
    {
        return view('settings.account');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui');
    }
}
