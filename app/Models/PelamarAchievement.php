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
        'file_bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
