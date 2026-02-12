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
        'saw_rank',

        // SNAP IDENTITAS
        'snap_name',
        'snap_email',
        'snap_phone',
        'snap_location',
        'snap_age',
        'snap_gender',
        'snap_last_education',
        'snap_photo',
        'snap_about',

        // SNAP SAW
        'snap_pendidikan_nilai',
        'snap_pengalaman_tahun',
        'snap_total_skill',

        // SNAP DETAIL
        'snap_experiences',
        'snap_educations',
        'snap_skills',
        'snap_certificates',
        'snap_organizations',
        'snap_achievements',
        'snap_resume',
    ];

    protected $casts = [
        'interview_at' => 'datetime',
        'snap_experiences'   => 'array',
        'snap_educations'    => 'array',
        'snap_skills'        => 'array',
        'snap_certificates'  => 'array',
        'snap_organizations' => 'array',
        'snap_achievements'  => 'array',
        'snap_resume'        => 'array',
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
