<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SCREENING = 'screening';
    const STATUS_DITOLAK_ADMIN = 'ditolak_administrasi';
    const STATUS_SELEKSI = 'seleksi';
    const STATUS_TIDAK_LOLOS_SAW = 'tidak_lolos_saw';
    const STATUS_INTERVIEW = 'interview';
    const STATUS_OFFER = 'offer';
    const STATUS_DITERIMA = 'diterima';
    const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'status',
        'interview_at',
        'interview_method',
        'interview_link',
        'offer_file',
        'offer_response',
        'saw_score',
        'saw_rank'
    ];

    protected $casts = [
        'interview_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
