<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;

class SeleksiController extends Controller
{
public function tentukanInterview(Lowongan $lowongan)
{
    // 🔐 hanya HRD pemilik
    abort_if($lowongan->hrd_id !== auth()->id(), 403);

    // ❌ CEK APAKAH SAW SUDAH DIHITUNG
    $sawSudahAda = Application::where('lowongan_id', $lowongan->id)
        ->whereNotNull('saw_score')
        ->exists();

    if (!$sawSudahAda) {
        return back()->with(
            'error',
            'Hitung SAW terlebih dahulu sebelum menentukan kandidat interview.'
        );
    }

    // ===============================
    // LOGIKA INTERVIEW
    // ===============================
    $jumlahDiterima = $lowongan->jumlah_diterima;
    $multiplier = 3;
    $jumlahInterview = $jumlahDiterima * $multiplier;

    $kandidat = Application::where('lowongan_id', $lowongan->id)
        ->where('status', 'seleksi')
        ->orderBy('saw_rank')
        ->take($jumlahInterview)
        ->get();

    Application::whereIn('id', $kandidat->pluck('id'))
        ->update(['status' => 'interview']);

    return back()->with(
        'success',
        "Sebanyak {$jumlahInterview} kandidat ditetapkan ke tahap interview."
    );
}


}

//INI SUDAH TIDAK BERLAKU KARENA SAW LANGSUNG MENENTUKAN RANGKING