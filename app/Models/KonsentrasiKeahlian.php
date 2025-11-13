<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsentrasiKeahlian extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_keahlian_id',
        'nama_konsentrasi',
    ];

    public function programKeahlian()
    {
        return $this->belongsTo(ProgramKeahlian::class);
    }
}
