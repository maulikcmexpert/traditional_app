<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('role')->nullable();
            $table->unsignedBigInteger('sender_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_connections');
    }
};