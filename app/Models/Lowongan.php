<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hrd_id',
        'nama_lowongan',
        'bidang_kerja_id',
        'tipe_kerja',
        'sistem_kerja',
        'lokasi',
        'penempatan',
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
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_diterima',
    ];

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'lowongan_skill',
            'lowongan_id',
            'skill_id'
        );
    }

    public function hrd()
{
    return $this->belongsTo(User::class, 'hrd_id');
}
    
public function bidangKerja()
{
    return $this->belongsTo(BidangKerja::class);
}


public function isExpired()
{
    if (!$this->tanggal_selesai) return false;

    return Carbon::today()->gt(
        Carbon::parse($this->tanggal_selesai)
    );
}
}
