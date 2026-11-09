<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

  protected $fillable = [
    'wisata_id',
    'booking_code',
    'nama_lengkap',
    'email',
    'no_hp',
    'jumlah_pengunjung',
    'tanggal_kunjungan',
    'paket',
    'items',
    'total_bayar',
    'metode_pembayaran',
    'bukti_pembayaran',
    'status',
    'paid_at',
];
    protected $casts = [
        'booking_date' => 'date',
        'verified_at' => 'datetime',
        'rejected_at' => 'datetime',
        'items' => 'array',
    ];

    /**
     * Relasi ke model Wisata
     */
    public function wisata(): BelongsTo
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }

    /**
     * Relasi ke User yang memverifikasi
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Relasi ke User yang menolak
     */
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Scope untuk booking pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk booking verified
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}