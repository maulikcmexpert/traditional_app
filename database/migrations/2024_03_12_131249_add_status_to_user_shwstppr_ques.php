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
        Schema::table('user_shwstppr_ques', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('prefered_option');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_shwstppr_ques', function (Blueprint $table) {
            //
        });
    }
};
