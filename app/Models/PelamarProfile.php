<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarProfile extends Model
{
    protected $fillable = [
    'user_id',
    'phone',
    'location',
    'age',
    'gender',
    'last_education',
    'photo',
    'tentang_saya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return
            !empty(trim($this->phone ?? '')) &&
            !empty(trim($this->location ?? '')) &&
            !empty($this->age) &&
            !empty(trim($this->gender ?? '')) &&
            !empty(trim($this->last_education ?? '')) &&
            !empty($this->photo);
    }
}
