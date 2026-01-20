<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminRecruitmentReportExport implements FromCollection
{
    protected $from, $to, $lowonganId;

    public function __construct($from, $to, $lowonganId)
    {
        $this->from = $from;
        $this->to   = $to;
        $this->lowonganId = $lowonganId;
    }

    public function collection()
    {
        $q = Application::with('lowongan');

        if ($this->from && $this->to) {
            $q->whereBetween('created_at', [
                $this->from.' 00:00:00',
                $this->to.' 23:59:59'
            ]);
        }

        if ($this->lowonganId) {
            $q->where('lowongan_id', $this->lowonganId);
        }

        return $q->get();
    }
}
