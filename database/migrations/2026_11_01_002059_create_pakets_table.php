<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->string('kategori'); // tiket_masuk, paket_bundle, transportasi, wahana, layanan
            $table->string('icon')->default('badge'); // Material Symbols icon name
            $table->string('badge')->nullable(); // Wajib, Best Value, Sunrise, dll
            $table->string('badge_color')->default('primary'); // primary, secondary, tertiary
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};