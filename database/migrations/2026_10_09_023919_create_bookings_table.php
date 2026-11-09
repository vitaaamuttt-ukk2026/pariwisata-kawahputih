<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp');
            $table->integer('jumlah_pengunjung');
            $table->date('tanggal_kunjungan');
            $table->string('paket')->default('Paket Lengkap');
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->string('metode_pembayaran')->default('qris');
            $table->string('status')->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};