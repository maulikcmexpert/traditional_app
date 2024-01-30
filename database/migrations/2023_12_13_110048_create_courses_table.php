<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cover_image')->nullable();
            $table->string('class_title')->nullable();
            $table->string('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->enum('venue_type', ['in_person', 'online']);
            $table->string('street_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('slots')->nullable();
            $table->string('pricing')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('day')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};