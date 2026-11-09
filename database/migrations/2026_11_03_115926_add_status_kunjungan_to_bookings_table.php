<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status_kunjungan', ['belum', 'sedang', 'selesai'])->default('belum')->after('status');
            $table->timestamp('selesai_at')->nullable()->after('status_kunjungan');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['status_kunjungan', 'selesai_at']);
        });
    }
};