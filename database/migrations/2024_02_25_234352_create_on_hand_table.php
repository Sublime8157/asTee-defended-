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
        Schema::create('product_on_hand', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->integer('variation_id');
            $table->string('description')->nullable();
            $table->integer('gender');
            $table->integer('size');
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_on_hand');
    }
};
