<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    public function index($lowonganId)
    {
        // dummy data (nanti ganti dari DB)
        $kandidats = collect([
            [
                'nama' => 'Joodiva',
                'status' => 'Diproses',
                'tanggal' => '2025-12-14',
                'pendidikan' => 'S1',
                'pengalaman' => 5,
                'keahlian' => 3,
                'skor' => 82,
                'ranking' => 2,
            ],
            [
                'nama' => 'Naruto',
                'status' => 'Diterima',
                'tanggal' => '2025-12-01',
                'pendidikan' => 'SMK',
                'pengalaman' => 2,
                'keahlian' => 6,
                'skor' => 90,
                'ranking' => 1,
            ],
        ]);

        return view('hrd.kandidat.index', compact('kandidats'));
    }
}
