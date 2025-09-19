<?php
// app/Models/Testimoni.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';

    protected $fillable = [
        'id_pengunjung',
        'peminjaman_id',
        'nama',
        'testimoni',
        'pesan',
        'rating',
        'is_approved',
        'approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved' => 'boolean',
        'rating' => 'integer'
    ];

    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)->orWhere('approved', true);
    }

    // Accessor to get testimoni content from either column
    public function getTestimoniTextAttribute()
    {
        return $this->testimoni ?: $this->pesan;
    }

    // Optional relationship to pengunjung (for backward compatibility)
    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class, 'id_pengunjung');
    }

    // Relationship to peminjaman
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}