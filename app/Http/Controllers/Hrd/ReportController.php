<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\HrdReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * =====================================================
     * HALAMAN REPORT HRD
     * =====================================================
     */
    public function index(Request $request)
    {
        $hrdId = auth()->id();

        $from        = $request->from;
        $to          = $request->to;
        $lowonganId  = $request->lowongan_id;

        // 🔹 Dropdown lowongan milik HRD
        $lowongans = Lowongan::where('hrd_id', $hrdId)->get();

        // 🔹 Query utama aplikasi
        $query = Application::whereHas('lowongan', function ($q) use ($hrdId) {
            $q->where('hrd_id', $hrdId);
        });

        // 🔹 Filter tanggal
        if ($from && $to) {
            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }

        // 🔹 Filter lowongan (opsional)
        if ($lowonganId) {
            $query->where('lowongan_id', $lowonganId);
        }

        $apps = $query->get();

        // =============================
        // HITUNG STATISTIK
        // =============================
        $totalPelamar = $apps->count();
        $seleksi      = $apps->whereNotNull('saw_score')->count();
        $interview    = $apps->where('status', 'interview')->count();
        $hired        = $apps->where('offer_response', 'diterima')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($hired / $totalPelamar) * 100, 2)
            : 0;

        return view('hrd.report.index', [
            'from'          => $from,
            'to'            => $to,
            'lowonganId'    => $lowonganId,
            'lowongans'     => $lowongans,
            'totalPelamar'  => $totalPelamar,
            'seleksi'       => $seleksi,
            'interview'     => $interview,
            'hired'         => $hired,
            'persenLolos'   => $persenLolos,
        ]);
    }

    /**
     * =====================================================
     * EXPORT PDF
     * =====================================================
     */
    public function exportPdf(Request $request)
    {
        $data = $this->index($request)->getData();

        return Pdf::loadView('hrd.report.pdf', (array) $data)
            ->setPaper('A4', 'portrait')
            ->stream('laporan-rekrutmen-hrd.pdf');
    }

    /**
     * =====================================================
     * EXPORT EXCEL
     * =====================================================
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new HrdReportExport(
                auth()->id(),
                $request->from,
                $request->to,
                $request->lowongan_id
            ),
            'laporan-rekrutmen-hrd.xlsx'
        );
    }
}
