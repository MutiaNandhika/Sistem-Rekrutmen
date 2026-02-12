<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        return view('hrd.dashboard');
    }

    public function data()
    {
        $hrdId = auth()->id();
        $tahun = request('tahun', now()->year);
        $bulan = request('bulan', now()->month);

        $totalPelamar = Application::whereHas('lowongan', fn ($q) =>
                $q->where('hrd_id', $hrdId)
            )
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count();

        $rawLowongan = Lowongan::where('hrd_id', $hrdId)
            ->whereYear('created_at', $tahun)
            ->selectRaw('MONTH(created_at) bulan, COUNT(*) total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $lowongan = [];
        for ($i = 1; $i <= 12; $i++) {
            $lowongan[] = $rawLowongan[$i] ?? 0;
        }

        $rawFunnel = Application::whereHas('lowongan', fn ($q) =>
                $q->where('hrd_id', $hrdId)
            )
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $rawOffer = Application::whereHas('lowongan', fn ($q) =>
                $q->where('hrd_id', $hrdId)
            )
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->selectRaw('offer_response, COUNT(*) total')
            ->groupBy('offer_response')
            ->pluck('total', 'offer_response');

        $tidakRespon = Application::whereHas('lowongan', fn ($q) =>
                $q->where('hrd_id', $hrdId)
            )
            ->where('status', 'offer')
            ->whereNull('offer_response')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->where('updated_at', '<', now()->subDays(7))
            ->count();

        return response()->json([
            'stat' => [
                'total_pelamar'  => $totalPelamar,
            ],
            'lowongan' => $lowongan,
            'funnel' => [
                'diproses'  => $rawFunnel['diproses'] ?? 0,
                'screening' => $rawFunnel['screening'] ?? 0,
                'interview' => $rawFunnel['interview'] ?? 0,
                'offer'     => $rawFunnel['offer'] ?? 0,
                'hired'     => $rawOffer['diterima'] ?? 0,
            ],
            'offer' => [
                'dikirim'      => $rawOffer['dikirim'] ?? 0,
                'diterima'     => $rawOffer['diterima'] ?? 0,
                'ditolak'      => $rawOffer['ditolak'] ?? 0,
                'tidak_respon' => $tidakRespon,
            ]
        ]);
    }
}
