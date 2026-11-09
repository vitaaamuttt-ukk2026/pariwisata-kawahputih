<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('reservasis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_tamu');
        $table->integer('jumlah_pax');
        $table->string('status')->default('Menunggu'); // Menunggu, Hadir, Batal
        $table->date('tanggal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
