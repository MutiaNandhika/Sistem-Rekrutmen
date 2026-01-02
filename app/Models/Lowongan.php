<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hrd_id',
        'nama_lowongan',
        'bidang_kerja',
        'tipe_kerja',
        'sistem_kerja',
        'lokasi',
        'gaji_min',
        'gaji_max',
        'jenis_kelamin',
        'usia_min',
        'usia_max',
        'tanpa_batas_usia',
        'pendidikan_minimal',
        'pengalaman_kerja',
        'deskripsi_pekerjaan',
        'status',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'lowongan_skill');
    }
}
