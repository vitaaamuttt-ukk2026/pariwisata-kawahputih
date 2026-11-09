<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (PENGGABUNGAN) Ditambah pengecekan hasColumn: database proyek A sudah memiliki
     * kolom ini (dibuat migrasi 2026_11_07_000001), sehingga tanpa pengecekan
     * `php artisan migrate` akan gagal "duplicate column".
     */
    public function up(): void
   {
       if (!Schema::hasColumn('bookings', 'bukti_pembayaran')) {
           Schema::table('bookings', function (Blueprint $table) {
               $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
           });
       }
   }

   public function down(): void
   {
       if (Schema::hasColumn('bookings', 'bukti_pembayaran')) {
           Schema::table('bookings', function (Blueprint $table) {
               $table->dropColumn('bukti_pembayaran');
           });
       }
   }
};
