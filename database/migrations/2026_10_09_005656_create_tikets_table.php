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
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('nama_pengunjung');
            $table->string('no_hp');
            $table->date('tanggal_kunjungan');
            $table->string('paket_wisata');
            $table->integer('jumlah_tiket');
            $table->integer('total_harga');
            $table->integer('kode_unik');
            $table->enum('status_pembayaran', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};