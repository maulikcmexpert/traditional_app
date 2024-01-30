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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->foreignId('document_type_id')->constrained('document_type');
            $table->string('document')->nullable();
            $table->string('document_number')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('about')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('achievement')->nullable();
            $table->string('skill')->nullable();
            $table->string('hobby')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('other_link')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};