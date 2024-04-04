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
        Schema::table('verification_objects', function (Blueprint $table) {
            $table->renameColumn('question', 'object_type');
            $table->renameColumn('post_image', 'object_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verification_objects', function (Blueprint $table) {
            //
        });
    }
};
