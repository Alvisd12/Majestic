<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
        'id_admin',
        'judul',
        'slug',
        'isi',
        'gambar',
        'published'
    ];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->judul);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}