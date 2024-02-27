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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_price')->nullable();
            $table->enum('subscription_type',['normal','pro']);
            $table->string('duration')->nullable();
            $table->enum('status',['0','1'])->comment('0 = inactive,1=active');
            $table->string('subscription_name')->nullable();
            $table->string('display_name')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
