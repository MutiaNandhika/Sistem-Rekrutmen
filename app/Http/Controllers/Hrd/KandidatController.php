<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;

class KandidatController extends Controller
{
    // LIST KANDIDAT PER LOWONGAN
    public function index(Lowongan $lowongan)
{
    // 🔐 SECURITY: hanya HRD pemilik lowongan
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    $kandidats = Application::with([
        'user.pelamarProfile',
        'user.pelamarEducations',
        'user.pelamarExperiences',
        'user.pelamarSkills'
    ])
    ->where('lowongan_id', $lowongan->id)
    ->orderBy('created_at') // penting untuk SAW & ranking
    ->get();

    return view('hrd.kandidat.index', compact('lowongan', 'kandidats'));
}

    // DETAIL KANDIDAT
    public function show(Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);

        $application->load([
            'user.pelamarProfile',
            'user.pelamarEducations',
            'user.pelamarSkills',
            'user.pelamarExperiences',
            'user.pelamarAchievements',
            'user.pelamarCertificates',
            'user.pelamarResume'
        ]);

        return view('hrd.kandidat.detail', compact('lowongan', 'application'));
    }
}
