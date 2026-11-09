<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wisata extends Model
{
    protected $table = 'wisatas';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'lokasi',
        'gambar',
    ];

    /**
     * Relasi ke Booking
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}