<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kolom status (jika belum ada)
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->enum('status', ['pending', 'verified', 'rejected'])
                      ->default('pending')
                      ->after('total_price');
            }
            
            // Kolom verifikasi
            if (!Schema::hasColumn('bookings', 'verified_by')) {
                $table->foreignId('verified_by')
                      ->nullable()
                      ->after('status')
                      ->constrained('users')
                      ->nullOnDelete();
            }
            
            if (!Schema::hasColumn('bookings', 'verified_at')) {
                $table->timestamp('verified_at')
                      ->nullable()
                      ->after('verified_by');
            }
            
            // Kolom penolakan
            if (!Schema::hasColumn('bookings', 'rejected_by')) {
                $table->foreignId('rejected_by')
                      ->nullable()
                      ->after('verified_at')
                      ->constrained('users')
                      ->nullOnDelete();
            }
            
            if (!Schema::hasColumn('bookings', 'rejected_at')) {
                $table->timestamp('rejected_at')
                      ->nullable()
                      ->after('rejected_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn(['status', 'verified_by', 'verified_at', 'rejected_by', 'rejected_at']);
        });
    }
};