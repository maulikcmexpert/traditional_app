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
        Schema::create('profile_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blocker_user_id')->nullable();
            $table->foreign('blocker_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('to_be_blocked_user_id')->nullable();
            $table->foreign('to_be_blocked_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('reason')->nullable();
            // $table->enum('status',['block','unblock']);
            $table->dateTime('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_blocks');
    }
};
