<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operasional_settings', function (Blueprint $table) {
            $table->id();
            $table->string('suhu')->default('28°C');
            $table->string('kondisi_cuaca')->default('Cerah');
            $table->string('status_angin')->default('Tenang');
            $table->string('peringatan_cuaca')->default('Normal');
            $table->integer('kuota_pengunjung')->default(1200);
            $table->integer('pengunjung_aktif')->default(0);
            $table->string('status_suaran')->default('Normal');
            $table->text('buletin_lapangan')->nullable();
            $table->string('status_gerbang')->default('Buka Normal');
            $table->integer('zona_terumbu_karang')->default(320);
            $table->integer('zona_terumbu_max')->default(400);
            $table->integer('zona_mangrove')->default(180);
            $table->integer('zona_mangrove_max')->default(250);
            $table->string('status_dermaga')->default('Aktif');
            $table->text('info_dermaga')->nullable();
            $table->timestamps();
        });

        // Insert data default
        DB::table('operasional_settings')->insert([
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('operasional_settings');
    }
};