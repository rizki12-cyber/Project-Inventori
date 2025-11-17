<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // admin, wakasek, kabeng
        'jurusan',   // nullable (hanya untuk kabeng)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // app/Models/User.php
public function konsentrasi()
{
    return $this->belongsTo(KonsentrasiKeahlian::class, 'jurusan', 'id');
}

}
