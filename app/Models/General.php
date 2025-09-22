<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    use HasFactory;
    
    protected $table = 'general';
    
    protected $fillable = [
        'persyaratan',
        'jam_operasional',
        'lokasi'
    ];
    
    // Ensure only one record can exist
    public static function getSingle()
    {
        return self::first() ?: new self();
    }
    
    public static function updateOrCreateSingle($data)
    {
        $general = self::first();
        if ($general) {
            $general->update($data);
            return $general;
        } else {
            return self::create($data);
        }
    }
}
