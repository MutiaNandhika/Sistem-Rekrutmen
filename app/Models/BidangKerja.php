<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidangKerja extends Model
{
    use HasFactory;

    protected $table = 'bidang_kerja';

    protected $fillable = ['nama'];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class);
    }
}
