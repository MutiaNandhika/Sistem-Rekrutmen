<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\User;

class LowonganMonitoringController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::with([
                'hrd',
                'bidangKerja'
            ])
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->get();

        $hrds = User::where('role', 'hrd')
            ->orderBy('name')
            ->get();

        return view('admin.monitoring.lowongan', [
            'lowongans' => $lowongans,
            'hrds'      => $hrds,
        ]);
    }

    public function show(Lowongan $lowongan)
    {
        $lowongan->load(['hrd', 'bidangKerja']);

        return view('admin.monitoring.lowongan-detail', [
            'lowongan' => $lowongan,
        ]);
    }
}
