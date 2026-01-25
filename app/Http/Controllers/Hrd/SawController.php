<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SawExport;
use Maatwebsite\Excel\Facades\Excel;

class SawController extends Controller
{
public function index(Lowongan $lowongan)
{
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    $apps = Application::with([
            'user.pelamarEducations',
            'user.pelamarExperiences',
            'user.pelamarSkills',
        ])
        ->where('lowongan_id', $lowongan->id)
        ->whereIn('status', [
            'seleksi',
            'interview',
            'tidak_lolos_saw'
        ])
        ->orderByRaw('saw_rank IS NULL, saw_rank ASC')
        ->orderBy('created_at')
        ->get();

    $sawSudahDihitung = $apps->whereNotNull('saw_score')->count() > 0;

    return view('hrd.seleksi.index', [
        'lowongan' => $lowongan,
        'apps'     => $apps,
        'sawDone'  => $sawSudahDihitung,
    ]);
}


    /**
     * =====================================================
     * HITUNG SAW (DIPANGGIL DARI BUTTON SCREENING)
     * =====================================================
     */
    public function hitung(Lowongan $lowongan)
    {

            // 🔐 hanya HRD pemilik lowongan
        abort_if($lowongan->hrd_id !== auth()->id(), 403);

    $cek = Application::where('lowongan_id', $lowongan->id)
    ->whereIn('status', ['seleksi','interview','tidak_lolos_saw'])
    ->whereNotNull('saw_score')
    ->exists();

if ($cek) {
    return back()->with('error', 'SAW sudah pernah dihitung. Silakan reset jika ingin mengulang.');
}

        // 🔥 AMBIL HANYA KANDIDAT LOLOS ADMIN
        $applications = Application::with([
                'user.pelamarEducations',
                'user.pelamarExperiences',
                'user.pelamarSkills',
            ])
            ->where('lowongan_id', $lowongan->id)
            ->where('status', 'seleksi')
            ->get();

        if ($applications->isEmpty()) {
            return back()->with('error', 'Tidak ada kandidat lolos administrasi');
        }

        /**
         * ===============================
         * STEP 1: DATA AWAL (MATRIX X)
         * ===============================
         */
         $data = [];

        foreach ($applications as $app) {
            $user = $app->user;

            $data[$app->id] = [
                'pendidikan' => $user->nilaiPendidikanTerakhir(),
                'pengalaman' => $user->totalPengalamanTahun(),
                'skill'      => $user->pelamarSkills->count(),
            ];
        }


        /**
         * ===============================
         * STEP 2: NORMALISASI
         * Rij = Xij / Max(Xj)
         * ===============================
         */
        $maxPendidikan = max(array_column($data, 'pendidikan'));
        $maxPengalaman = max(array_column($data, 'pengalaman'));
        $maxSkill      = max(array_column($data, 'skill'));

        $normalisasi = [];

        foreach ($data as $appId => $nilai) {
            $normalisasi[$appId] = [
                'r1' => $maxPendidikan > 0 ? $nilai['pendidikan'] / $maxPendidikan : 0,
                'r2' => $maxPengalaman > 0 ? $nilai['pengalaman'] / $maxPengalaman : 0,
                'r3' => $maxSkill > 0 ? $nilai['skill'] / $maxSkill : 0,
            ];
        }

        /**
         * ===============================
         * STEP 3: BOBOT
         * ===============================
         */
        $bobot = [
            'r1' => 0.30, // Pendidikan
            'r2' => 0.40, // Pengalaman
            'r3' => 0.30, // Skill
        ];

        /**
         * ===============================
         * STEP 4: HITUNG SKOR AKHIR
         * ===============================
         */
        $skorAkhir = [];

        foreach ($normalisasi as $appId => $r) {
            $skorAkhir[$appId] =
                ($r['r1'] * $bobot['r1']) +
                ($r['r2'] * $bobot['r2']) +
                ($r['r3'] * $bobot['r3']);
        }

        /**
         * ===============================
         * STEP 5: RANKING
         * ===============================
         */
        arsort($skorAkhir); // ranking tertinggi = 1

        $limitInterview = $lowongan->jumlah_diterima * 3;
        $rank = 1;

        foreach ($skorAkhir as $appId => $score) {

            Application::where('id', $appId)->update([
                'saw_score' => round($score, 3),
                'saw_rank'  => $rank,
                'status'    => $rank <= $limitInterview
                    ? 'interview'
                    : 'tidak_lolos_saw'
            ]);

            $rank++;
        }

        return back()->with('success', 'Perhitungan SAW & seleksi kandidat berhasil');
    }

    /**
     * =====================================================
     * HALAMAN LAPORAN SAW
     * =====================================================
     */
    public function laporan(Lowongan $lowongan)
    {
        // 🔐 keamanan
        abort_if($lowongan->hrd_id !== auth()->id(), 403);

        $apps = Application::with([
        'user.pelamarEducations',
        'user.pelamarExperiences',
        'user.pelamarSkills',
        ])
        ->where('lowongan_id', $lowongan->id)
        ->whereNotNull('saw_score')
        ->whereIn('status', ['interview', 'tidak_lolos_saw'])
        ->orderBy('saw_rank')
        ->get();

        // ===============================
        // CEK DATA SAW
        // ===============================
        if ($apps->isEmpty()) {
        return view('hrd.laporan.index', [
            'lowongan'    => $lowongan,
            'apps'        => collect(),
            'matrix'      => [],
            'normalisasi' => [],
        ]);
    }


        /**
         * ===============================
         * DATA AWAL (MATRIX X)
         * ===============================
         */
        $matrix = [];

        foreach ($apps as $app) {
            $user = $app->user;

            $matrix[$app->id] = [
                'nama'       => $user->name,
                'pendidikan' => $user->nilaiPendidikanTerakhir(),
                'pengalaman' => $user->totalPengalamanTahun(),
                'skill'      => $user->pelamarSkills->count(),
            ];
        }

        /**
         * ===============================
         * NORMALISASI
         * ===============================
         */
        $maxC1 = max(array_column($matrix, 'pendidikan'));
        $maxC2 = max(array_column($matrix, 'pengalaman'));
        $maxC3 = max(array_column($matrix, 'skill'));

        $normalisasi = [];

        foreach ($matrix as $appId => $val) {
            $normalisasi[$appId] = [
                'r1' => $maxC1 > 0 ? $val['pendidikan'] / $maxC1 : 0,
                'r2' => $maxC2 > 0 ? $val['pengalaman'] / $maxC2 : 0,
                'r3' => $maxC3 > 0 ? $val['skill'] / $maxC3 : 0,
            ];
        }

        return view('hrd.laporan.index', compact(
            'lowongan',
            'apps',
            'matrix',
            'normalisasi'
        ));
    }

    /**
     * =====================================================
     * EXPORT PDF
     * =====================================================
     */
    public function exportPdf(Lowongan $lowongan)
{
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    $apps = Application::with([
            'user.pelamarEducations',
            'user.pelamarExperiences',
            'user.pelamarSkills',
        ])
        ->where('lowongan_id', $lowongan->id)
        ->whereNotNull('saw_score')
        ->orderBy('saw_rank')
        ->get();

    // 🔥 MATRIX DATA (C1, C2, C3)
    $matrix = [];

    foreach ($apps as $app) {
        $user = $app->user;

        $matrix[$app->id] = [
    'nama'       => $user->name,
    'pendidikan' => $user->nilaiPendidikanTerakhir(),
    'pengalaman' => $user->totalPengalamanTahun(),
    'skill'      => $user->pelamarSkills->count(),
];

    }

    return Pdf::loadView(
            'hrd.laporan.saw-pdf',
            compact('lowongan', 'apps', 'matrix')
        )
        ->setPaper('A4', 'portrait')
        ->stream('laporan-saw-' . $lowongan->id . '.pdf');
}
public function exportExcel(Lowongan $lowongan)
{
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    return Excel::download(
        new SawExport($lowongan->id),
        'laporan-saw-' . $lowongan->id . '.xlsx'
    );
}

public function reset(Lowongan $lowongan)
{
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    Application::where('lowongan_id', $lowongan->id)
        ->whereIn('status', ['seleksi', 'interview', 'tidak_lolos_saw'])
        ->update([
            'saw_score'        => null,
            'saw_rank'         => null,
            'interview_at'     => null,
            'interview_method' => null,
            'interview_link'   => null,
            'status'           => 'seleksi',
        ]);

    return back()->with('success', 'Reset SAW berhasil (tanpa mengganggu kandidat diterima).');
}


}
