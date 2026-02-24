<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploaded_files';

    protected $fillable = ['name', 'file_path'];
}