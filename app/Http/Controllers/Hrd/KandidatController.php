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
        // ❗ TIDAK BOLEH abort — HRD lain boleh lihat
        $isOwner = $lowongan->hrd_id === auth()->id();

        $kandidats = Application::with([
                'user.pelamarProfile',
                'user.pelamarEducations',
                'user.pelamarExperiences',
                'user.pelamarSkills',
            ])
            ->where('lowongan_id', $lowongan->id)
            ->orderBy('created_at')
            ->get();

        return view('hrd.kandidat.index', [
            'lowongan'  => $lowongan,
            'kandidats' => $kandidats,
            'isOwner'   => $isOwner,
        ]);
    }

     /**
     * DETAIL KANDIDAT
     */
    public function show(Lowongan $lowongan, Application $application)
    {
        // ❗ TIDAK abort — viewer allowed
        $isOwner = $lowongan->hrd_id === auth()->id();

        // 🔐 pastikan kandidat milik lowongan
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        $application->load([
            'user.pelamarProfile',
            'user.pelamarEducations',
            'user.pelamarSkills',
            'user.pelamarExperiences',
            'user.pelamarAchievements',
            'user.pelamarCertificates',
            'user.pelamarResume',
        ]);

        return view('hrd.kandidat.detail', [
            'lowongan'    => $lowongan,
            'application' => $application,
            'isOwner'     => $isOwner,
        ]);
    }

public function lolosAdministrasi(Lowongan $lowongan, Application $application)
{
    // 🔐 hanya HRD pemilik lowongan
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    // 🔐 pastikan application milik lowongan ini
    abort_if($application->lowongan_id !== $lowongan->id, 404);

    // ✅ hanya boleh dari tahap screening
    if ($application->status !== 'screening') {
        return back()->with('error', 'Kandidat tidak berada pada tahap screening.');
    }

    // 🔄 lolos administrasi → masuk tahap seleksi (SAW)
    $application->update([
        'status' => 'seleksi',
    ]);

    return back()->with('success', 'Kandidat berhasil lolos administrasi.');
}

}
