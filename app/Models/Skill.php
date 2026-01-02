<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['nama_skill'];

    public function lowongans()
    {
        return $this->belongsToMany(
            Lowongan::class,
            'lowongan_skill'
        );
    }
}
