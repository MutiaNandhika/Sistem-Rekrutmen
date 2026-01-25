<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function index()
    {
        $applications = Application::with('lowongan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pelamar.lamaran-index', compact('applications'));
    }

    public function show(Application $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);

        return view('pelamar.lamaran', compact('application'));
    }

    public function store(Lowongan $lowongan)
    {
        $user = auth()->user();

        abort_if($lowongan->status !== 'aktif', 403);

        if (!$user->isProfileComplete()) {
            return redirect()
                ->route('pelamar.profile')
                ->with('error', 'Lengkapi profil terlebih dahulu');
        }

        // ✅ CEGAH LAMARAN GANDA (SELAMA MASIH AKTIF)
        $existing = Application::where('user_id', $user->id)
            ->whereIn('status', [
                'diproses',
                'screening',
                'seleksi',
                'interview',
                'offer',
            ])
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

    /**
     * ===============================
     * TERIMA / TOLAK OFFER
     * ===============================
     */
    public function offerResponse(Request $request, Application $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);
        abort_if($application->status !== 'offer', 403);

        $request->validate([
            'response' => 'required|in:diterima,ditolak'
        ]);

        $status = match ($request->response) {
            'diterima' => 'diterima',
            'ditolak'  => 'offer_ditolak',
        };

        $application->update([
            'offer_response' => $request->response,
            'status'         => $status,
        ]);

        return back()->with('success', 'Keputusan berhasil dikirim.');
    }
}
