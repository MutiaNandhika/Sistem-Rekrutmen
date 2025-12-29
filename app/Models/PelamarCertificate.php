<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarCertificate extends Model
{
    protected $table = 'pelamar_certificates';
    protected $fillable = [
        'user_id',
        'nama_sertifikat',
        'organisasi_penerbit',
        'bulan_terbit',
        'tahun_terbit',
        'tanpa_expired',
        'bulan_expired',
        'tahun_expired',
        'informasi_tambahan',
    ];

    protected $casts = [
        'tanpa_expired' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
