<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarResume extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
