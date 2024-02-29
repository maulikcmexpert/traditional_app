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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('country_code')->nullable();
            $table->unsignedBigInteger('country')->nullable();
            $table->foreign('country')->references('id')->on('countries')->onDelete('cascade');
            $table->string('mobile_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('user_type', ['user', 'admin', 'organization'])->default('user');
            $table->string('otp')->nullable();
            $table->enum('is_ghost', ['0', '1'])->default('0')->comment('0 = not ghost, 1 = ghost');
            $table->enum('is_verified', ['0', '1'])->default('0')->comment('0 = OTP not verified, 1 = Verified');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
