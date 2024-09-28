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
        Schema::create('abn_armenian_payments', function (Blueprint $table) {
            $table->id();
            $table->text('payment_response')->nullable();
            $table->enum('payment_status', ['new', 'pending', 'failed', 'success']);
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abn_armenian_payments');
    }
};
