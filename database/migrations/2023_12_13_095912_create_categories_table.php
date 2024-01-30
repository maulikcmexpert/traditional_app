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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};