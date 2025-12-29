<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarSkill extends Model
{
    protected $table = 'pelamar_skills';
    protected $fillable = [
        'user_id',
        'nama_skill',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
