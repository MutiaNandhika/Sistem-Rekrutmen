<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HrdReportExport implements FromCollection, WithHeadings
{
    protected $hrdId;
    protected $from;
    protected $to;

    public function __construct($hrdId, $from = null, $to = null)
    {
        $this->hrdId = $hrdId;
        $this->from  = $from;
        $this->to    = $to;
    }

    public function collection(): Collection
    {
        $query = Application::whereHas('lowongan', function ($q) {
            $q->where('hrd_id', $this->hrdId);
        });

        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [
                $this->from.' 00:00:00',
                $this->to.' 23:59:59'
            ]);
        }

        $apps = $query->get();

        $totalPelamar = $apps->count();
        $lolosSAW     = $apps->whereNotNull('saw_score')->count();
        $interview    = $apps->where('status','interview')->count();
        $hired        = $apps->where('offer_response','diterima')->count();

        $persen = $totalPelamar > 0
            ? round(($hired / $totalPelamar) * 100, 2)
            : 0;

        return collect([
            [
                'Periode'         => ($this->from && $this->to)
                    ? $this->from.' s/d '.$this->to
                    : 'Semua',
                'Total Pelamar'   => $totalPelamar,
                'Lolos SAW'       => $lolosSAW,
                'Interview'       => $interview,
                'Hired'           => $hired,
                'Persentase (%)'  => $persen
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Total Pelamar',
            'Lolos SAW',
            'Interview',
            'Hired',
            'Persentase Lolos (%)'
        ];
    }
}
