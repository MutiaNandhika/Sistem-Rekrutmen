<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarOrganization extends Model
{
    protected $table = 'pelamar_organizations';
    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'posisi',
        'mulai_bulan',
        'mulai_tahun',
        'masih_aktif',
        'selesai_bulan',
        'selesai_tahun',
        'informasi_tambahan',
    ];

    protected $casts = [
        'masih_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
