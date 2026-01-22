<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PelamarProfile;
use App\Models\PelamarExperience;
use App\Models\PelamarEducation;
use App\Models\PelamarSkill;
use App\Models\PelamarResume;
use App\Models\PelamarCertificate;
use App\Models\PelamarOrganization;
use App\Models\PelamarAchievement;
use App\Models\Application;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

/**
     * =========================
     *  RELATIONS: PELAMAR
     * =========================
     */

    // 1-1 profile
    public function pelamarProfile()
    {
        return $this->hasOne(PelamarProfile::class);
    }

    // 1-N pengalaman
    public function pelamarExperiences()
    {
        return $this->hasMany(PelamarExperience::class);
    }

    // 1-N pendidikan
    public function pelamarEducations()
    {
        return $this->hasMany(PelamarEducation::class);
    }

    // 1-N skill
    public function pelamarSkills()
    {
        return $this->hasMany(PelamarSkill::class);
    }

    // 1-1 resume
    public function pelamarResume()
    {
        return $this->hasOne(PelamarResume::class);
    }

    // 1-N sertifikat
    public function pelamarCertificates()
    {
        return $this->hasMany(PelamarCertificate::class);
    }

    // 1-N organisasi
    public function pelamarOrganizations()
    {
        return $this->hasMany(PelamarOrganization::class);
    }

    // 1-N achievement
    public function pelamarAchievements()
    {
        return $this->hasMany(PelamarAchievement::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function isProfileComplete(): bool
{
    $profile = $this->pelamarProfile;

    // 1️⃣ data diri wajib
    if (!$profile || !$profile->isComplete()) {
        return false;
    }

    // 2️⃣ tentang saya wajib
    if (empty(trim($profile->tentang_saya ?? ''))) {
        return false;
    }

    // 3️⃣ minimal 1 pendidikan
    if (!$this->pelamarEducations()->exists()) {
        return false;
    }

    // 4️⃣ minimal 1 skill
    if (!$this->pelamarSkills()->exists()) {
        return false;
    }

    // 5️⃣ resume wajib
    if (!$this->pelamarResume) {
        return false;
    }

    return true;
}


public function totalPengalamanTahun(): float
{
    if ($this->pelamarExperiences->isEmpty()) {
        return 0;
    }

    $totalBulan = 0;

    foreach ($this->pelamarExperiences as $exp) {

        // ⛔ skip kalau tanggal_mulai kosong
        if (! $exp->tanggal_mulai) {
            continue;
        }

        try {
            // ✅ PAKAI NAMA KOLOM DATABASE YANG BENAR
            $start = \Carbon\Carbon::parse($exp->tanggal_mulai);

            // kalau masih bekerja → pakai hari ini
            if ($exp->masih_bekerja) {
                $end = now();
            } else {
                // kalau sudah selesai → pakai tanggal_selesai
                if (! $exp->tanggal_selesai) {
                    continue;
                }
                $end = \Carbon\Carbon::parse($exp->tanggal_selesai);
            }

            // validasi waktu
            if ($end->greaterThan($start)) {
                $totalBulan += $start->diffInMonths($end);
            }

        } catch (\Exception $e) {
            // skip data rusak
            continue;
        }
    }

    return round($totalBulan / 12, 1);
}

public function nilaiPendidikanTerakhir(): int
{
    if ($this->pelamarEducations->isEmpty()) {
        return 0;
    }

    $map = [
        'SMA' => 1,
        'SMK' => 1,
        'D3'  => 2,
        'S1'  => 3,
        'S2'  => 4,
        'S3'  => 5,
    ];

    $nilai = 0;

    foreach ($this->pelamarEducations as $edu) {
        if (isset($map[$edu->tingkat])) {
            $nilai = max($nilai, $map[$edu->tingkat]);
        }
    }

    return $nilai;
}

public function lowongans()
{
    return $this->hasMany(Lowongan::class, 'hrd_id');
}

public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

}


