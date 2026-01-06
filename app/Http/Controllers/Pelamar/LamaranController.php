<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function store(Lowongan $lowongan)
    {
        $user = auth()->user();

        // LOWONGAN HARUS AKTIF
        abort_if($lowongan->status !== 'aktif', 403);

        // PROFIL HARUS LENGKAP
        if (!$user->isProfileComplete()) {
            return redirect()
                ->route('pelamar.profile')
                ->with('error', 'Lengkapi profil terlebih dahulu');
        }

        // CEK LAMARAN AKTIF (SELAMA BUKAN DITOLAK)
        $existing = Application::where('user_id', $user->id)
            ->whereNotIn('status', ['ditolak'])
            ->exists();

        if ($existing) {
            return back()->with(
                'error',
                'Kamu masih memiliki lamaran yang sedang diproses.'
            );
        }

        Application::create([
            'user_id'     => $user->id,
            'lowongan_id' => $lowongan->id,
            'status'      => 'diproses',
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim.');
    }

    // ===============================
    // TERIMA / TOLAK OFFER
    // ===============================
    public function offerResponse(Request $request, Application $application)
    {
        // 🔐 hanya pelamar pemilik
        abort_if($application->user_id !== auth()->id(), 403);

        // ❌ BELUM OFFER
        abort_if($application->status !== 'offer', 403);

        $request->validate([
            'response' => 'required|in:diterima,ditolak'
        ]);

        $application->update([
            'offer_response' => $request->response,
            'status' => $request->response === 'diterima'
                ? 'diterima'
                : 'ditolak'
        ]);

        return back()->with('success', 'Keputusan berhasil dikirim');
    }
}
