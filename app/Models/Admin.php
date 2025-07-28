<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'phone',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class, 'id_admin');
    }

    public function blog(): HasMany
    {
        return $this->hasMany(Blog::class, 'id_admin');
    }
}