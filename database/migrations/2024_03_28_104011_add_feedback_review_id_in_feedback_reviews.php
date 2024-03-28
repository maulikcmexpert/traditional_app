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
        Schema::table('feedback_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('feedback_review_id')->nullable();
            $table->foreign('feedback_review_id')->references('id')->on('feedback_review_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_reviews', function (Blueprint $table) {
            //
        });
    }
};
