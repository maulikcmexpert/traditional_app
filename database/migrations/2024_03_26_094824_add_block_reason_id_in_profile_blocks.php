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
        Schema::table('profile_blocks', function (Blueprint $table) {
            $table->unsignedBigInteger('block_reason_id')->after('full_name')->after('to_be_blocked_user_id');
            $table->foreign('block_reason_id')->references('id')->on('block_reasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_blocks', function (Blueprint $table) {
            //
        });
    }
};
