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
        Schema::create('product_on_return_cancel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('variation_id');
            $table->string('description')->nullable();
            $table->integer('reason')->nullable();
            $table->unsignedBigInteger('gender');
            $table->unsignedBigInteger('size');
            $table->integer('price');
            $table->integer('quantity');  
            $table->timestamps();


            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('gender')->references('id')->on('genders');
            $table->foreign('size')->references('id')->on('sizes');         
           $table->foreign('userId')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_on_return_cancel');
    }
};
