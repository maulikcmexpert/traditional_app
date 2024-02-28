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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date_of_birth');
            $table->text('address');
            $table->enum('gender',['male','female']);
            $table->double('lattitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('education')->nullable();
            $table->text('about_me')->nullable();
            $table->unsignedBigInteger('zodiac_sign_id')->nullable();
            $table->foreign('zodiac_sign_id')->references('id')->on('zodiac_signs')->onDelete('cascade');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('age')->nullable();
            // $table->string('profile');
            // $table->string('religion');
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
