<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // hero, info_cards, mood_recommendations, photo_spots, favorites, hotels, gallery, info_page
            $table->string('key'); // identifier unik untuk setiap konten
            $table->string('type')->default('text'); // text, image, number, json
            $table->text('value')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};