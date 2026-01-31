<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminReportExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;
    protected $lowonganId;

    public function __construct($from, $to, $lowonganId)
    {
        $this->from       = $from;
        $this->to         = $to;
        $this->lowonganId = $lowonganId;
    }

    public function collection(): Collection
    {
        $query = Application::query();

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
        $screening    = $apps->where('status', 'screening')->count();
        $seleksi      = $apps->where('status', 'seleksi')->count();
        $interview    = $apps->where('status', 'interview')->count();
        $offer        = $apps->where('status', 'offer')->count();
        $diterima     = $apps->where('offer_response', 'diterima')->count();
        $ditolak      = $apps->where('offer_response', 'ditolak')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($diterima / $totalPelamar) * 100, 2)
            : 0;

        $periode = ($this->from && $this->to)
            ? "{$this->from} s/d {$this->to}"
            : 'Semua Periode';

        return collect([[
            $periode,
            (string) $totalPelamar,
            (string) $screening,
            (string) $seleksi,
            (string) $interview,
            (string) $offer,
            (string) $diterima,
            (string) $ditolak,
            (string) $persenLolos,
        ]]);
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
}
