<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'wisata_id')) {
                $table->unsignedBigInteger('wisata_id')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('wisata_id');
        });
    }
};