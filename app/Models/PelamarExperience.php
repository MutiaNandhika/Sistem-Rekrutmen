<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarExperience extends Model
{
    protected $table = 'pelamar_experiences';
    protected $fillable = [
        'user_id',
        'posisi',
        'perusahaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'masih_bekerja',
        'deskripsi',
        'file_bukti',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'masih_bekerja' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
