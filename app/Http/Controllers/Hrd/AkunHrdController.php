<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\User;

class AkunHrdController extends Controller
{
    public function show($id)
    {
        $user = User::where('role', 'hrd')->findOrFail($id);

        return view('hrd.akun-hrd', compact('user'));
    }
}
