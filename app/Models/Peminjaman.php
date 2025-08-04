<?php
// app/Models/Peminjaman.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    
    protected $fillable = [
        'user_id',
        'nama',
        'no_handphone',
        'tanggal_rental',
        'jam_sewa',
        'jenis_motor',
        'durasi_sewa',
        'total_harga',
        'bukti_jaminan',
        'foto_ktp',
        'status',
        'tanggal_kembali',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_rental' => 'date',
        'tanggal_kembali' => 'date',
        'jam_sewa' => 'datetime:H:i',
        'total_harga' => 'decimal:2',
        'durasi_sewa' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class, 'user_id');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Pending' => 'warning',
            'Confirmed' => 'info',
            'Belum Kembali' => 'danger',
            'Disewa' => 'primary',
            'Selesai' => 'success',
            'Cancelled' => 'dark',
            default => 'secondary'
        };
    }

    public function getTanggalSelesaiAttribute()
    {
        return $this->tanggal_rental->addDays($this->durasi_sewa);
    }

    public function getIsOverdueAttribute()
    {
        if (in_array($this->status, ['Selesai', 'Cancelled'])) return false;
        return now() > $this->tanggal_selesai;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['Confirmed', 'Belum Kembali', 'Disewa']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Selesai');
    }
}