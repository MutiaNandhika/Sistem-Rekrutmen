<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $fillable = [
        'judul',
        'perusahaan',
        'tipe_pekerjaan',
        'lokasi',
        'status'
    ];
}
