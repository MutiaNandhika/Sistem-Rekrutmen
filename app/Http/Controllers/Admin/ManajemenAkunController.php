<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenAkunController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->role, function ($q) use ($request) {
            $q->where('role', $request->role);
        })
        ->orderBy('name')
        ->get();

        return view('admin.manajemen-akun', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,hrd,pelamar',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Akun berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,hrd,pelamar',
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $data['password']
                ? Hash::make($data['password'])
                : $user->password,
        ]);

        return back()->with('success', 'Akun berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri.'
            ], 422);
        }

        if ($user->role === 'hrd' && $user->lowongans()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun HRD tidak dapat dihapus karena sudah memiliki data lowongan.'
            ], 422);
        }

        if ($user->role === 'pelamar' && $user->applications()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pelamar tidak dapat dihapus karena sudah memiliki data lamaran.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}
