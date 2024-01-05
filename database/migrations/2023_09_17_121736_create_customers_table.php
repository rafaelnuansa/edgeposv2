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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('customer_code')->unique();
            $table->string('email')->unique();
            $table->bigInteger('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('postal_code')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->string('dob')->nullable();
            $table->decimal('credit_limit', 8,2)->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
