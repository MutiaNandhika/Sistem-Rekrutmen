<?php

namespace App\Exports;

use App\Models\Application;
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
            'Total Pelamar',
            'Screening',
            'Seleksi (SAW)',
            'Interview',
            'Offer',
            'Selesai - Diterima',
            'Selesai - Ditolak',
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

        $totalPelamar = (int) $apps->count();
        $screening    = (int) $apps->where('status', 'screening')->count();
        $seleksi      = (int) $apps->where('status', 'seleksi')->count();
        $interview    = (int) $apps->where('status', 'interview')->count();
        $offer        = (int) $apps->where('status', 'offer')->count();
        $diterima     = (int) $apps->where('offer_response', 'diterima')->count();
        $ditolak      = (int) $apps->where('offer_response', 'ditolak')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($diterima / $totalPelamar) * 100, 2)
            : 0;

        $periode = ($this->from && $this->to)
            ? "{$this->from} s/d {$this->to}"
            : 'Semua Periode';

        return [[
        $periode,
        (string) $totalPelamar,
        (string) $screening,
        (string) $seleksi,
        (string) $interview,
        (string) $offer,
        (string) $diterima,
        (string) $ditolak,
        (string) $persenLolos,
    ]];

    }
}
