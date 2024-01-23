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
        Schema::create('hold_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->bigInteger('price');
            $table->timestamps();

            // Relationship with holds
            $table->foreign('hold_id')->references('id')->on('holds')->onDelete('cascade');

            // Relationship with products
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_items');
    }
};
