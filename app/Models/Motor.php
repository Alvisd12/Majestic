<?php
// app/Models/Motor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $table = 'motor';

    protected $fillable = [
        'merk',
        'model',
        'tahun',
        'plat_nomor',
        'harga_per_hari',
        'status',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'harga_per_hari' => 'decimal:2',
        'tahun' => 'integer',
    ];

    public function getFullNameAttribute()
    {
        return $this->merk . ' ' . $this->model . ' (' . $this->tahun . ')';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Tersedia' => 'success',
            'Disewa' => 'warning',
            'Maintenance' => 'danger',
            default => 'secondary'
        };
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'Tersedia');
    }
}