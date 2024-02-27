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
        Schema::create('user_love_langs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('love_lang_id')->nullable();
            $table->foreign('love_lang_id')->references('id')->on('love_langs')->onDelete('cascade');
            $table->integer('rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_love_langs');
    }
};
