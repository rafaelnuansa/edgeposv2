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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->string('invoice');
            $table->decimal('cash', 8,2);
            $table->decimal('change');
            $table->string('payment_method');
            $table->decimal('discount', 8,2);
            $table->decimal('total_amount', 8,2)->default(0);
            $table->decimal('remaining_amount', 8,2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            //relationship users
            $table->foreign('cashier_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete()->cascadeOnUpdate();
            //relationship customers
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
