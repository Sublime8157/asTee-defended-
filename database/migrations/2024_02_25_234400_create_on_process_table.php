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
        Schema::create('product_on_process', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('variation_id');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('gender');
            $table->unsignedBigInteger('size');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('total');
            $table->unsignedBigInteger('productStatus');
            $table->timestamps();

            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('gender')->references('id')->on('genders');
            $table->foreign('size')->references('id')->on('sizes');         
            $table->foreign('productStatus')->references('id')->on('product_status');
            $table->foreign('userId')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_on_process');
    }
};
