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
        Schema::create('file_size_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('photo_size');
            $table->integer('video_size');
            $table->integer('document_size');
            $table->integer('audio_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_size_masters');
    }
};
