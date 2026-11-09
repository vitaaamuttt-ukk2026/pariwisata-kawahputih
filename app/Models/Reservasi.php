<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'nama_tamu',
        'jumlah_pax',
        'status',
        'tanggal',
    ];
}