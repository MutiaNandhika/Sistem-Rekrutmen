<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Application;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AdminRecruitmentReportExport;
use App\Exports\AdminReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from;
        $to   = $request->to;
        $lowonganId = $request->lowongan_id;

        $lowongans = Lowongan::orderBy('nama_lowongan')->get();

        $query = Application::with('lowongan');

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

        $totalPelamar   = $apps->count();
        $screening      = $apps->where('status', 'screening')->count();
        $seleksi        = $apps->whereNotNull('saw_score')->count();
        $interview      = $apps->where('status', 'interview')->count();
        $hired          = $apps->where('offer_response', 'diterima')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($hired / $totalPelamar) * 100, 2)
            : 0;

        return view('admin.report.index', compact(
            'lowongans',
            'apps',
            'from',
            'to',
            'lowonganId',
            'totalPelamar',
            'screening',
            'seleksi',
            'interview',
            'hired',
            'persenLolos'
        ));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->index($request)->getData();

        return Pdf::loadView('admin.report.pdf', (array) $data)
            ->setPaper('A4', 'portrait')
            ->stream('report-rekrutmen.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new AdminReportExport(
                $request->from,
                $request->to,
                $request->lowongan_id
            ),
            'report-rekrutmen.xlsx'
        );
    }

}
