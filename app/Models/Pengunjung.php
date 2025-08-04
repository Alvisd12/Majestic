<?php
// app/Models/Pengunjung.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengunjung extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengunjung';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    public function testimoni(): HasMany
    {
        return $this->hasMany(Testimoni::class, 'id_pengunjung');
    }
}