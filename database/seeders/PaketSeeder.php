<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama' => 'Tiket Masuk WNI',
                'deskripsi' => 'Tiket masuk Kawah Putih untuk wisatawan domestik.',
                'harga' => 30000,
                'kategori' => 'tiket_masuk',
                'icon' => 'person',
                'badge' => 'Wajib',
                'badge_color' => 'primary',
                'urutan' => 1,
            ],
            [
                'nama' => 'Tiket Masuk WNA',
                'deskripsi' => 'Tiket masuk Kawah Putih untuk wisatawan mancanegara.',
                'harga' => 80000,
                'kategori' => 'tiket_masuk',
                'icon' => 'public',
                'badge' => null,
                'badge_color' => 'secondary',
                'urutan' => 2,
            ],
            [
                'nama' => 'Paket WNI + Shuttle',
                'deskripsi' => 'Tiket masuk WNI dan shuttle Ontang-anting pulang-pergi.',
                'harga' => 50000,
                'kategori' => 'paket_bundle',
                'icon' => 'directions_bus',
                'badge' => 'Hemat',
                'badge_color' => 'primary',
                'urutan' => 1,
            ],
            [
                'nama' => 'Shuttle Ontang-anting PP',
                'deskripsi' => 'Transportasi resmi pulang-pergi dari area parkir menuju Kawah Putih.',
                'harga' => 25000,
                'kategori' => 'transportasi',
                'icon' => 'directions_bus',
                'badge' => null,
                'badge_color' => 'secondary',
                'urutan' => 1,
            ],
            [
                'nama' => 'Jembatan Ponton',
                'deskripsi' => 'Akses berjalan di atas jembatan ponton untuk menikmati pemandangan kawah.',
                'harga' => 15000,
                'kategori' => 'wahana',
                'icon' => 'bridge',
                'badge' => null,
                'badge_color' => 'tertiary',
                'urutan' => 1,
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::firstOrCreate(
                ['nama' => $paket['nama']],
                $paket + ['is_active' => true]
            );
        }
    }
}
