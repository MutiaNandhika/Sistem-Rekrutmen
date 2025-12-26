<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AkunAdminController extends Controller
{
    public function show($id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);

        return view('admin.akun-admin', compact('user'));
    }
}
