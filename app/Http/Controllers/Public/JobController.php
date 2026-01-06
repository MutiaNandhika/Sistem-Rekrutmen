<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * LIST + SEARCH
     */
    public function index(Request $request)
    {
        $query = Lowongan::query()
            ->where('status', 'aktif');

        // 🔍 FILTER POSISI
        if ($request->filled('posisi')) {
            $query->where('nama_lowongan', 'like', '%' . $request->posisi . '%');
        }

        // 🔍 FILTER LOKASI
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // 🔍 FILTER PENEMPATAN
        if ($request->filled('penempatan')) {
            $query->where('penempatan', 'like', '%' . $request->penempatan . '%');
        }

        // 🔍 FILTER TIPE KERJA
        if ($request->filled('tipe_kerja')) {
            $query->where('tipe_kerja', $request->tipe_kerja);
        }

        // 🔍 FILTER SISTEM KERJA
        if ($request->filled('sistem_kerja')) {
            $query->where('sistem_kerja', $request->sistem_kerja);
        }

        $lowongans = $query->latest()->get();

        // 🔥 CEK: PELAMAR SUDAH MELAMAR / STATUS APA
        $application = null;

        if (Auth::check() && Auth::user()->role === 'pelamar') {
            $application = Application::where('user_id', Auth::id())
                ->latest()
                ->first();
        }

        return view('public.jobs.index', compact('lowongans', 'application'));
    }

    /**
     * DETAIL
     */
    public function show(Lowongan $lowongan)
{
    abort_if($lowongan->status !== 'aktif', 404);

    $lowongan->load('skills');

    $application = null;

    if (auth()->check() && auth()->user()->role === 'pelamar') {
        $application = \App\Models\Application::where('user_id', auth()->id())
            ->latest()
            ->first();
    }

    return view('public.jobs.show', compact('lowongan', 'application'));
}

}
