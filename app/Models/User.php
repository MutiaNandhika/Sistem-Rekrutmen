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
}

