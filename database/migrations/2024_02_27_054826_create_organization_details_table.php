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
        Schema::create('organization_details', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('established_year');
            $table->unsignedBigInteger('size_of_organization_id')->nullable();
            $table->foreign('size_of_organization_id')->references('id')->on('size_of_organizations')->onDelete('cascade');
            $table->text('address');
            $table->unsignedBigInteger('city')->nullable();
            $table->foreign('city')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('state')->nullable();
            $table->foreign('state')->references('id')->on('states')->onDelete('cascade');
            $table->text('about_us');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_details');
    }
};
