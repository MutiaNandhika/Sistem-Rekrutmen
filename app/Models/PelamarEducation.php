<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarEducation extends Model
{
    protected $table = 'pelamar_educations';
    protected $fillable = [
        'user_id',
        'tingkat',
        'nama_sekolah',
        'bidang_studi',
        'mulai_bulan',
        'mulai_tahun',
        'selesai_bulan',
        'selesai_tahun',
        'informasi_tambahan',
        'file_bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
