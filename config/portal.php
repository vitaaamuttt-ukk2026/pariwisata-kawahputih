<?php

/*
| FILE BARU (penggabungan). Memilih tampilan portal PENGUNJUNG:
|   'b' (bawaan) = tampilan proyek B  -> terhubung CMS admin (paket, info, hero, operasional)
|   'a'          = tampilan proyek A  -> desain baru (keranjang, sidebar/mobile nav), statis
| Ubah lewat .env:  VISITOR_THEME=a   lalu jalankan: php artisan config:clear
| Tema 'a' memakai Vite, jalankan `npm run dev` (atau `npm run build`).
*/
return [
    'visitor_theme' => env('VISITOR_THEME', 'b'),
];
