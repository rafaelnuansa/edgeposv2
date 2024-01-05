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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('sales_invoice_id');
            $table->unsignedBigInteger('receiving_invoice_id');
            $table->unsignedBigInteger('created_by');

            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
