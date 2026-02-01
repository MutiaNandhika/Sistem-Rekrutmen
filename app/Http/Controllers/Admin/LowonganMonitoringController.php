<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\User;

class LowonganMonitoringController extends Controller
{
    /**
     * ===============================
     * LIST LOWONGAN (MONITORING)
     * ===============================
     */
    public function index()
{
    $lowongans = Lowongan::with([
            'hrd',
            'bidangKerja'
        ])
        ->withCount('applications') // 👈 INI INTINYA
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


    /**
     * ===============================
     * DETAIL LOWONGAN (READ ONLY)
     * ===============================
     */
    public function show(Lowongan $lowongan)
    {
        // eager load biar rapi
        $lowongan->load(['hrd', 'bidangKerja']);

        return view('admin.monitoring.lowongan-detail', [
            'lowongan' => $lowongan,
        ]);
    }
}
