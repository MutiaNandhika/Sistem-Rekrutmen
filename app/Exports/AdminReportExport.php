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

    public function __construct($from = null, $to = null, $lowonganId = null)
    {
        $this->from        = $from;
        $this->to          = $to;
        $this->lowonganId  = $lowonganId;
    }

    public function collection(): Collection
    {
        $query = Application::query();

        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [
                $this->from.' 00:00:00',
                $this->to.' 23:59:59'
            ]);
        }

        if ($this->lowonganId) {
            $query->where('lowongan_id', $this->lowonganId);
        }

        $apps = $query->get();

        $totalPelamar = $apps->count();
        $screening    = $apps->where('status', 'screening')->count();
        $seleksi      = $apps->whereNotNull('saw_score')->count();
        $interview    = $apps->where('status', 'interview')->count();
        $hired        = $apps->where('offer_response', 'diterima')->count();

        $persenLolos = $totalPelamar > 0
            ? round(($hired / $totalPelamar) * 100, 2)
            : 0;

        return collect([
            [
                'Periode'        => ($this->from && $this->to)
                    ? $this->from.' s/d '.$this->to
                    : 'Semua',
                'Total Pelamar'  => $totalPelamar,
                'Screening'      => $screening,
                'Seleksi (SAW)'  => $seleksi,
                'Interview'      => $interview,
                'Hired'          => $hired,
                'Lolos (%)'      => $persenLolos,
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Total Pelamar',
            'Screening',
            'Seleksi (SAW)',
            'Interview',
            'Hired',
            'Lolos (%)',
        ];
    }
}
