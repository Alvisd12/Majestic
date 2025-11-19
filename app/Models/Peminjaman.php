<?php
// app/Models/Peminjaman.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    
    protected $fillable = [
        'user_id',
        'motor_id',
        'tanggal_rental',
        'jam_sewa',
        'pilihan_pengambilan',
        'alamat_pengiriman',
        'jenis_motor',
        'durasi_sewa',
        'total_harga',
        'denda',
        'bukti_jaminan',
        'status',
        'tanggal_kembali',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_rental' => 'date',
        'tanggal_kembali' => 'date',
        'jam_sewa' => 'datetime:H:i',
        'total_harga' => 'decimal:2',
        'denda' => 'decimal:2',
        'durasi_sewa' => 'integer'
    ];

    // Auto-calculate tanggal_kembali based on tanggal_rental and durasi_sewa
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($peminjaman) {
            if ($peminjaman->tanggal_rental && $peminjaman->durasi_sewa) {
                $peminjaman->tanggal_kembali = $peminjaman->tanggal_rental->addDays($peminjaman->durasi_sewa);
            }
        });
        
        static::updating(function ($peminjaman) {
            if ($peminjaman->isDirty(['tanggal_rental', 'durasi_sewa'])) {
                $peminjaman->tanggal_kembali = $peminjaman->tanggal_rental->addDays($peminjaman->durasi_sewa);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class, 'user_id');
    }

    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class, 'motor_id');
    }

    public function getStatusColorAttribute()
    {
        return match(true) {
            $this->status === 'Menunggu Konfirmasi' => 'warning',
            $this->status === 'Dikonfirmasi' => 'info',
            str_starts_with($this->status, 'Terlambat') => 'danger',
            $this->status === 'Sedang Disewa' => 'primary',
            $this->status === 'Selesai' => 'success',
            str_starts_with($this->status, 'Selesai (Telat') => 'danger',
            $this->status === 'Dibatalkan' => 'dark',
            // Legacy status support
            $this->status === 'Pending' => 'warning',
            $this->status === 'Confirmed' => 'info',
            $this->status === 'Belum Kembali' => 'danger',
            $this->status === 'Disewa' => 'primary',
            $this->status === 'Cancelled' => 'dark',
            default => 'secondary'
        };
    }

    public function getTanggalSelesaiAttribute()
    {
        return $this->tanggal_rental->addDays($this->durasi_sewa);
    }

    public function getIsOverdueAttribute()
    {
        if (str_starts_with($this->status, 'Selesai') || $this->status === 'Dibatalkan' || $this->status === 'Cancelled') return false;
        
        // Check if current date is past the expected return date
        $expectedReturnDate = $this->tanggal_rental->addDays($this->durasi_sewa);
        return now()->startOfDay()->gt($expectedReturnDate->startOfDay());
    }

    public function scopePending($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'Menunggu Konfirmasi')
              ->orWhere('status', 'Pending'); // Legacy support
        });
    }

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereIn('status', ['Dikonfirmasi', 'Sedang Disewa'])
              ->orWhere('status', 'like', 'Terlambat%')
              // Legacy support
              ->orWhereIn('status', ['Confirmed', 'Belum Kembali', 'Disewa']);
        });
    }

    public function scopeCompleted($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'Selesai')
              ->orWhere('status', 'like', 'Selesai (Telat%');
        });
    }

    /**
     * Calculate penalty for overdue rental
     */
    public function calculateDenda()
    {
        // Only calculate penalty for overdue rentals
        if (!$this->isOverdue || str_starts_with($this->status, 'Selesai') || $this->status === 'Dibatalkan' || $this->status === 'Cancelled') {
            return 0;
        }

        $expectedReturnDate = $this->tanggal_rental->addDays($this->durasi_sewa)->startOfDay();
        $currentDate = now()->startOfDay();
        
        // Calculate overdue days from expected return date
        $overdueDays = ceil($expectedReturnDate->diffInDays($currentDate, false));
        
        if ($overdueDays <= 0) {
            return 0;
        }

        // Get daily rental price from motor or calculate from total price
        $dailyPrice = $this->motor ? $this->motor->harga_per_hari : ($this->total_harga / $this->durasi_sewa);
        
        return $overdueDays * $dailyPrice;
    }

    /**
     * Update penalty amount in database
     */
    public function updateDenda()
    {
        $calculatedDenda = $this->calculateDenda();
        
        if ($this->denda != $calculatedDenda) {
            $this->update(['denda' => $calculatedDenda]);
        }
        
        return $calculatedDenda;
    }

    /**
     * Get overdue days count
     */
    public function getOverdueDaysAttribute()
    {
        if (!$this->isOverdue || str_starts_with($this->status, 'Selesai') || $this->status === 'Dibatalkan' || $this->status === 'Cancelled') {
            return 0;
        }

        $expectedReturnDate = $this->tanggal_rental->addDays($this->durasi_sewa)->startOfDay();
        $currentDate = now()->startOfDay();
        
        return max(0, ceil($expectedReturnDate->diffInDays($currentDate, false)));
    }

    /**
     * Get total amount including penalty
     */
    public function getTotalWithDendaAttribute()
    {
        return $this->total_harga + $this->denda;
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusIndonesiaAttribute()
    {
        return match(true) {
            $this->status === 'Pending' => 'Menunggu Konfirmasi',
            $this->status === 'Confirmed' => 'Dikonfirmasi',
            $this->status === 'Disewa' => 'Sedang Disewa',
            $this->status === 'Belum Kembali' => 'Terlambat',
            $this->status === 'Cancelled' => 'Dibatalkan',
            str_starts_with($this->status, 'Terlambat') => $this->status,
            str_starts_with($this->status, 'Selesai') => $this->status,
            default => $this->status
        };
    }

    /**
     * Get overdue days for completed rentals
     */
    public function getCompletedOverdueDaysAttribute()
    {
        if (!$this->tanggal_kembali) return 0;
        
        $expectedReturnDate = $this->tanggal_rental->addDays($this->durasi_sewa)->startOfDay();
        $actualReturnDate = Carbon::parse($this->tanggal_kembali)->startOfDay();
        
        if ($actualReturnDate->gt($expectedReturnDate)) {
            return ceil($expectedReturnDate->diffInDays($actualReturnDate, false));
        }
        
        return 0;
    }
}