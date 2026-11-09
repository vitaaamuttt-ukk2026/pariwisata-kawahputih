<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'booking_code',
    'nama_lengkap',
    'email',
    'no_hp',
    'jumlah_pengunjung',
    'tanggal_kunjungan',
    'paket',
    'total_bayar',
    'metode_pembayaran',
    'bukti_pembayaran',
    'status',
    'status_kunjungan',
    'paid_at',
    'selesai',    
];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'paid_at' => 'datetime',
        'total_bayar' => 'decimal:2',
    ];
    
}