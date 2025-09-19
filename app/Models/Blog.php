<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
        'id_admin',
        'judul',
        'isi',
        'gambar',
        'penulis',
        'lokasi',
        'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
