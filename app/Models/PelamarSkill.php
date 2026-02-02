<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarSkill extends Model
{
    protected $fillable = [
        'user_id',
        'skill_id',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
