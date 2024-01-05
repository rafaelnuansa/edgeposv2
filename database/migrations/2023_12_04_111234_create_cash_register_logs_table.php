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
        Schema::create('cash_register_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cash_register_id');
            $table->double('opening_amount')->nullable();
            $table->double('closing_amount')->nullable();
            $table->string('status');
            $table->timestamp('opening_time')->nullable();
            $table->timestamp('closing_time')->nullable();
            $table->unsignedBigInteger('opened_by')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_register_logs');
    }
};
