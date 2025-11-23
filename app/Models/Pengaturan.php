<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'logo_sekolah',
        'favicon',
    ];
}
