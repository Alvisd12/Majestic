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
        'pesan',
        'rating',
        'approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean'
    ];

    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class, 'id_pengunjung');
    }

    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
}