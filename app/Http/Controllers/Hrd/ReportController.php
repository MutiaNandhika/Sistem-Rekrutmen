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
    public function index(Request $request)
    {
        $hrdId = auth()->id();

        $from       = $request->from;
        $to         = $request->to;
        $lowonganId = $request->lowongan_id;

        // ==========================
        // LOWONGAN MILIK HRD
        // ==========================
        $lowongans = Lowongan::where('hrd_id', $hrdId)->get();

        // ==========================
        // QUERY UTAMA
        // ==========================
        $query = Application::whereHas('lowongan', function ($q) use ($hrdId) {
            $q->where('hrd_id', $hrdId);
        });

        if ($from && $to) {
            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }

        if ($lowonganId) {
            $query->where('lowongan_id', $lowonganId);
        }

        $apps = $query->get();

        // ==========================
        // STATISTIK (SESUAI DEFINISI BARU)
        // ==========================
        $totalPelamar = $apps->count();

        $screening = $apps->where('status', 'screening')->count();

        // sebelum dihitung SAW
        $seleksiSaw = $apps->where('status', 'seleksi')->count();

        $interview = $apps->where('status', 'interview')->count();

        $offer = $apps->where('status', 'offer')->count();

        $diterima = $apps->where('offer_response', 'diterima')->count();
        $ditolak  = $apps->where('offer_response', 'ditolak')->count();

        // ==========================
        // PERSENTASE LOLOS
        // ==========================
        $persenLolos = $totalPelamar > 0
            ? round(($diterima / $totalPelamar) * 100, 2)
            : 0;

        return view('hrd.report.index', compact(
            'from',
            'to',
            'lowonganId',
            'lowongans',
            'totalPelamar',
            'screening',
            'seleksiSaw',
            'interview',
            'offer',
            'diterima',
            'ditolak',
            'persenLolos'
        ));
    }

    // ==========================
    // EXPORT PDF
    // ==========================
    public function exportPdf(Request $request)
    {
        $data = $this->index($request)->getData();

        return Pdf::loadView('hrd.report.pdf', (array) $data)
            ->setPaper('A4', 'portrait')
            ->stream('laporan-rekrutmen-hrd.pdf');
    }

    // ==========================
    // EXPORT EXCEL
    // ==========================
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
