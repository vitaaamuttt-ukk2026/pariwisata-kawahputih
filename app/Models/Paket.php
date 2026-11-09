<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'icon',
        'badge',
        'badge_color',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'integer',
        'urutan' => 'integer',
    ];

    // Scope untuk kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori)->where('is_active', true)->orderBy('urutan');
    }

    // Scope aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}