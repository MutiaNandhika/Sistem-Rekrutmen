<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    /**
     * =====================================================
     * LIST KANDIDAT PER LOWONGAN + FILTER STATUS
     * =====================================================
     */
    public function index(Request $request, Lowongan $lowongan)
    {
        // ❗ HRD lain boleh lihat (read-only)
        $isOwner = $lowongan->hrd_id === auth()->id();

        $query = Application::with([
                'user.pelamarProfile',
                'user.pelamarEducations',
                'user.pelamarExperiences',
                'user.pelamarSkills',
            ])
            ->where('lowongan_id', $lowongan->id)
            ->orderBy('created_at', 'asc');

        /**
         * =============================
         * FILTER STATUS (SARAN DOSEN)
         * =============================
         */
        if ($request->filled('status')) {

            // Selesai - Ditolak (gabungan)
            if ($request->status === 'ditolak') {
                $query->whereIn('status', [
                    'ditolak',
                    'tidak_lolos_saw',
                    'ditolak_administrasi',
                ]);
            } else {
                // Status tunggal
                $query->where('status', $request->status);
            }
        }

        $kandidats = $query->get();

        return view('hrd.kandidat.index', [
            'lowongan'  => $lowongan,
            'kandidats' => $kandidats,
            'isOwner'   => $isOwner,
        ]);
    }

    /**
     * =====================================================
     * DETAIL KANDIDAT
     * =====================================================
     */
    public function show(Lowongan $lowongan, Application $application)
    {
        // ❗ viewer allowed
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

    /**
     * =====================================================
     * LOLOS ADMINISTRASI → MASUK SELEKSI (SAW)
     * =====================================================
     */
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

        // 🔄 screening → seleksi (SAW)
        $application->update([
            'status' => 'seleksi',
        ]);

        return back()->with('success', 'Kandidat berhasil lolos administrasi.');
    }

    public function tolakAdministrasi(Lowongan $lowongan, Application $application)
{
    // 🔐 hanya HRD pemilik
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    // 🔐 pastikan kandidat milik lowongan
    abort_if($application->lowongan_id !== $lowongan->id, 404);

    // ✅ hanya dari screening
    if ($application->status !== 'screening') {
        return back()->with('error', 'Kandidat tidak berada pada tahap screening.');
    }

    // ❌ TOLAK ADMINISTRASI
    $application->update([
        'status' => 'ditolak_administrasi',
    ]);

    return back()->with('success', 'Kandidat ditolak pada tahap administrasi.');
}

}
