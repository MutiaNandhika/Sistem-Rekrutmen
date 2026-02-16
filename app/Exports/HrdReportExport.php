<?php

namespace App\Exports;

use App\Models\Application;
use App\Models\Lowongan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HrdReportExport implements FromArray, WithHeadings
{
    protected $hrdId;
    protected $from;
    protected $to;
    protected $lowonganId;

    public function __construct($hrdId, $from, $to, $lowonganId)
    {
        $this->hrdId      = $hrdId;
        $this->from       = $from;
        $this->to         = $to;
        $this->lowonganId = $lowonganId;
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Lowongan',
            'Total Pelamar',
            'Diproses',
            'Screening',
            'Seleksi (SAW)',
            'Tidak Lolos SAW',
            'Interview',
            'Offer',
            'Offer Ditolak',
            'Selesai - Diterima',
            'Selesai - Ditolak',
            'Ditolak Administrasi',
            'Persentase Lolos (%)',
        ];
    }

    public function array(): array
    {
        $query = Application::whereHas('lowongan', function ($q) {
            $q->where('hrd_id', $this->hrdId);
        });

        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [
                $this->from . ' 00:00:00',
                $this->to   . ' 23:59:59'
            ]);
        }

        if ($this->lowonganId) {
            $query->where('lowongan_id', $this->lowonganId);
        }

        $apps = $query->get();

        $totalPelamar = $apps->count();
        $diproses     = $apps->where('status', 'diproses')->count();
        $screening    = $apps->where('status', 'screening')->count();
        $seleksi      = $apps->where('status', 'seleksi')->count();
        $tidakLolos   = $apps->where('status', 'tidak_lolos_saw')->count();
        $interview    = $apps->where('status', 'interview')->count();
        $offer        = $apps->where('status', 'offer')->count();
        $offerDitolak = $apps->where('status', 'offer_ditolak')->count();
        $diterima     = $apps->where('offer_response', 'diterima')->count();
        $ditolak      = $apps->where('offer_response', 'ditolak')->count();
        $ditolakAdm   = $apps->where('status', 'ditolak_administrasi')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($diterima / $totalPelamar) * 100, 2)
            : 0;

        $periode = ($this->from && $this->to)
            ? "{$this->from} s/d {$this->to}"
            : 'Semua Periode';

        $namaLowongan = $this->lowonganId
            ? optional(Lowongan::find($this->lowonganId))->nama_lowongan
            : 'Semua Lowongan';

        return [[
            $periode,
            $namaLowongan,
            (string) ($totalPelamar ?? 0),
            (string) ($diproses ?? 0),
            (string) ($screening ?? 0),
            (string) ($seleksi ?? 0),
            (string) ($tidakLolos ?? 0),
            (string) ($interview ?? 0),
            (string) ($offer ?? 0),
            (string) ($offerDitolak ?? 0),
            (string) ($diterima ?? 0),
            (string) ($ditolak ?? 0),
            (string) ($ditolakAdm ?? 0),
            (string) ($persenLolos ?? 0),
        ]];
    }
}
