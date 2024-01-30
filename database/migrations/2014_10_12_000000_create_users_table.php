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
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password')->unique()->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin','learner','educator','host','institute','company'])->default('learner');
            $table->enum('social_type',['google','facebook'])->nullable();
            $table->string('social_token')->nullable();
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->softDeletes();
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