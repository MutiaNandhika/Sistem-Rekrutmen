<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AdminReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from       = $request->from;
        $to         = $request->to;
        $lowonganId = $request->lowongan_id;

        $lowongans = Lowongan::orderBy('nama_lowongan')->get();

        $query = Application::query();

        if ($from && $to) {
            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }

        if ($lowonganId) {
            $query->where('lowongan_id', $lowonganId);
            $namaLowongan = Lowongan::find($lowonganId)?->nama_lowongan ?? '-';
        } else {
            $namaLowongan = 'Semua Lowongan';
        }

        $apps = $query->get();

        $totalPelamar        = $apps->count();
        $diproses            = $apps->where('status', 'diproses')->count();
        $screening           = $apps->where('status', 'screening')->count();
        $seleksi             = $apps->where('status', 'seleksi')->count();
        $tidakLolosSaw       = $apps->where('status', 'tidak_lolos_saw')->count();
        $interview           = $apps->where('status', 'interview')->count();
        $offer               = $apps->where('status', 'offer')->count();
        $offerDitolak        = $apps->where('status', 'offer_ditolak')->count();
        $ditolakAdministrasi = $apps->where('status', 'ditolak_administrasi')->count();

        $diterima = $apps->where('offer_response', 'diterima')->count();
        $ditolak  = $apps->where('offer_response', 'ditolak')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($diterima / $totalPelamar) * 100, 2)
            : 0;

        return view('admin.report.index', compact(
            'lowongans',
            'from',
            'to',
            'lowonganId',
            'namaLowongan',
            'totalPelamar',
            'diproses',
            'screening',
            'seleksi',
            'tidakLolosSaw',
            'interview',
            'offer',
            'offerDitolak',
            'ditolakAdministrasi',
            'diterima',
            'ditolak',
            'persenLolos'
        ));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->index($request)->getData();

        return Pdf::loadView('admin.report.pdf', (array) $data)
            ->setPaper('A4', 'portrait')
            ->stream('laporan-rekrutmen-admin.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new AdminReportExport(
                $request->from,
                $request->to,
                $request->lowongan_id
            ),
            'laporan-rekrutmen-admin.xlsx'
        );
    }
}
