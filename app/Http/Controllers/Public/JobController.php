<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::where('status', 'aktif')
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                  ->orWhereDate('tanggal_selesai', '>=', now());
            });
            
        if ($request->filled('posisi')) {
            $query->where('nama_lowongan', 'like', '%' . $request->posisi . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('penempatan')) {
            $query->where('penempatan', 'like', '%' . $request->penempatan . '%');
        }

        if ($request->filled('tipe_kerja')) {
            $query->where('tipe_kerja', $request->tipe_kerja);
        }

        if ($request->filled('sistem_kerja')) {
            $query->where('sistem_kerja', $request->sistem_kerja);
        }

        $lowongans = $query->latest()->get();

        $application = null;

        if (Auth::check() && Auth::user()->role === 'pelamar') {
            $application = Application::where('user_id', Auth::id())
                ->latest()
                ->first();
        }

        return view('public.jobs.index', compact('lowongans', 'application'));
    }

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
