<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'lowongan_id',
        'status',
        'interview_at',
        'interview_method',
        'interview_link',
        'offer_file',
        'offer_response',
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
