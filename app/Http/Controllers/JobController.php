<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function show($id)
    {
        if (!Auth::check()) {

            // SIMPAN TUJUAN ASLI (DETAIL LOWONGAN)
            session(['url.intended' => url()->current()]);

            return redirect()->route('login', [
                'reason' => 'job_detail',
            ]);
        }

        return view('public.jobs.show', compact('id'));
    }
}