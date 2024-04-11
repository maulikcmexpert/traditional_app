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
        Schema::table('user_details', function (Blueprint $table) {
            $table->unsignedBigInteger('faith_id')->nullable();
            $table->foreign('faith_id')->references('id')->on('faiths')->onDelete('cascade');
            $table->unsignedBigInteger('body_type_id')->nullable();
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('cascade');
            $table->unsignedBigInteger('culture_id')->nullable();
            $table->foreign('culture_id')->references('id')->on('cultures')->onDelete('cascade');
            $table->unsignedBigInteger('daily_activity_id')->nullable();
            $table->foreign('daily_activity_id')->references('id')->on('daily_activities')->onDelete('cascade');
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->unsignedBigInteger('eating_habit_id')->nullable();
            $table->foreign('eating_habit_id')->references('id')->on('eating_habits')->onDelete('cascade');
            $table->string('vaccination_status')->nullable();
            $table->string('alcohol_status')->nullable();
            $table->string('smoke_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            //
        });
    }
};
