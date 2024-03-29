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
        Schema::table('approach_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_reason_id')->nullable()->after('message');
            $table->foreign('leave_reason_id')
                ->references('id')
                ->on('leave_reasons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approach_requests', function (Blueprint $table) {
            //
        });
    }
};
