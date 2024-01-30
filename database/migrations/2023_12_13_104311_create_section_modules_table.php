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
        Schema::create('section_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('module_name')->nullable();
            $table->string('created_by', 25)->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('section_modules');
    }
};