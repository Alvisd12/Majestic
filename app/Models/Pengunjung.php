<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model {
    protected $table = 'pengunjung';
    protected $fillable = ['nama', 'username', 'password', 'phone'];
}