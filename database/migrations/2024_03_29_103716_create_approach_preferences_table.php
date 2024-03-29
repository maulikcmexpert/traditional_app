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
        Schema::create('approach_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer("min_age");
            $table->integer("max_age");
            $table->varchar("religious_preference");
            $table->varchar("min_weight");
            $table->varchar("max_weight");
            $table->varchar("min_height");
            $table->varchar("max_height");
            $table->enum("preference_apply_in_search", ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approach_preferences');
    }
};
