<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SawExport implements FromCollection, WithHeadings, WithMapping
{
    protected $lowonganId;

    public function __construct($lowonganId)
    {
        $this->lowonganId = $lowonganId;
    }

    public function collection()
    {
        return Application::with([
                'user.pelamarEducations',
                'user.pelamarExperiences',
                'user.pelamarSkills',
            ])
            ->where('lowongan_id', $this->lowonganId)
            ->whereNotNull('saw_score')
            ->orderBy('saw_rank')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ranking',
            'Nama Kandidat',
            'C1 - Pendidikan',
            'C2 - Pengalaman (Tahun)',
            'C3 - Keahlian',
            'Skor SAW',
        ];
    }

    public function map($app): array
    {
        return [
            $app->saw_rank,
            $app->user->name,
            $app->user->nilaiPendidikanTerakhir(),
            $app->user->totalPengalamanTahun(),
            $app->user->pelamarSkills->count(),
            $app->saw_score,
        ];
    }
}
