<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarAchievement extends Model
{
    protected $table = 'pelamar_achievements';
    protected $fillable = [
        'user_id',
        'judul',
        'penyelenggara',
        'tahun',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
