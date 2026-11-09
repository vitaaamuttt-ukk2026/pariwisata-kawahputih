<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperasionalSetting extends Model
{
    protected $table = 'operasional_settings';
    
    protected $fillable = [
        'suhu', 'kondisi_cuaca', 'status_angin', 'peringatan_cuaca',
        'kuota_pengunjung', 'pengunjung_aktif', 'status_suaran',
        'buletin_lapangan', 'status_gerbang', 'zona_terumbu_karang',
        'zona_terumbu_max', 'zona_mangrove', 'zona_mangrove_max',
        'status_dermaga', 'info_dermaga',
    ];

    // Ambil data operasional (hanya ada 1 baris)
    public static function getSetting()
    {
        return self::first() ?? self::create([
            'suhu' => '28°C',
            'kondisi_cuaca' => 'Cerah',
            'status_angin' => 'Tenang',
            'peringatan_cuaca' => 'Normal',
            'kuota_pengunjung' => 1200,
            'pengunjung_aktif' => 0,
            'status_suaran' => 'Normal',
            'status_gerbang' => 'Buka Normal',
            'zona_terumbu_karang' => 320,
            'zona_terumbu_max' => 400,
            'zona_mangrove' => 180,
            'zona_mangrove_max' => 250,
            'status_dermaga' => 'Aktif',
        ]);
    }
}