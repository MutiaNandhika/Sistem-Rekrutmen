<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;

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

        return view('public.jobs.index', compact('lowongans'));
    }

    /**
     * DETAIL
     */
    public function show(Lowongan $lowongan)
    {
        abort_if($lowongan->status !== 'aktif', 404);

        // 🔥 WAJIB: eager load skill
        $lowongan->load('skills');

        return view('public.jobs.show', compact('lowongan'));
    }
}
