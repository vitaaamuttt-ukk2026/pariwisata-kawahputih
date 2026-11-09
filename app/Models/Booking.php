<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MODEL GABUNGAN (proyek A + proyek B).
 * - Relasi, scope pending/verified, kolom items/wisata_id  : berasal dari A
 * - Kolom user_id, status_kunjungan, selesai, casts tanggal : berasal dari B
 * - Konstanta status + scope lunas()/batal() + isLunas()/isBatal() : BARU, untuk
 *   menyatukan dua kosakata status (A: verified/rejected, B: paid/cancelled).
 */
class Booking extends Model
{
    use HasFactory;

    // Nilai status yang DITULIS (baku = kosakata A)
    public const STATUS_PENDING  = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';

    // Nilai status yang DIBACA (menerima juga kosakata lama B)
    public const STATUS_LUNAS = ['verified', 'paid'];
    public const STATUS_BATAL = ['rejected', 'cancelled'];

    protected $fillable = [
        // dari A
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
        // tambahan dari B
        'user_id',
        'status_kunjungan',
        'selesai',
    ];

    protected $casts = [
        // dari A
        'booking_date' => 'date',
        'verified_at'  => 'datetime',
        'rejected_at'  => 'datetime',
        'items'        => 'array',
        // dari B
        'tanggal_kunjungan' => 'date',
        'paid_at'           => 'datetime',
        'total_bayar'       => 'decimal:2',
    ];

    /** Relasi ke model Wisata (A) */
    public function wisata(): BelongsTo
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }

    /** Relasi ke User yang memverifikasi (A) */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /** Relasi ke User yang menolak (A) */
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /** BARU: booking yang sudah lunas/terverifikasi (menerima 'verified' dan 'paid') */
    public function scopeLunas($query)
    {
        return $query->whereIn('status', self::STATUS_LUNAS);
    }

    /** BARU: booking yang ditolak/dibatalkan (menerima 'rejected' dan 'cancelled') */
    public function scopeBatal($query)
    {
        return $query->whereIn('status', self::STATUS_BATAL);
    }

    public function isLunas(): bool
    {
        return in_array($this->status, self::STATUS_LUNAS, true);
    }

    public function isBatal(): bool
    {
        return in_array($this->status, self::STATUS_BATAL, true);
    }
}
