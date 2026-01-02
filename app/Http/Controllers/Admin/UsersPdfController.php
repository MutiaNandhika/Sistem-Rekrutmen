<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersPdfController extends Controller
{
    public function preview()
    {
        $query = User::query();

        if (request()->filled('role')) {
            $query->where('role', request('role'));
        }

        $users = $query->get();

        $pdf = Pdf::loadView('admin.exports.users-pdf', compact('users'));

        return $pdf->stream('akun.pdf');
    }
}
