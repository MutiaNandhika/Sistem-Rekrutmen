<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SawExport implements FromCollection, WithHeadings
{
    protected $lowonganId;

    public function __construct($lowonganId)
    {
        $this->lowonganId = $lowonganId;
    }

    public function collection()
    {
        $apps = Application::query()
            ->where('lowongan_id', $this->lowonganId)
            ->whereNotNull('saw_score')
            ->whereIn('status', ['interview', 'tidak_lolos_saw'])
            ->orderByDesc('saw_score')
            ->get();

        $rank = 1;

        return $apps->map(function ($app) use (&$rank) {
            return [
                'Ranking'       => $rank++,
                'Nama Kandidat' => $app->snap_name,
                'C1'            => $app->snap_pendidikan_nilai,
                'C2'            => $app->snap_pengalaman_tahun,
                'C3'            => $app->snap_total_skill,
                'Skor SAW'      => round($app->saw_score, 3),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ranking',
            'Nama Kandidat',
            'C1 - Pendidikan',
            'C2 - Pengalaman',
            'C3 - Keahlian',
            'Skor SAW',
        ];
    }
}
