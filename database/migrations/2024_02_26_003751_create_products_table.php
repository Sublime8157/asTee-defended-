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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('variation_id');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('gender');
            $table->unsignedBigInteger('size');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('productStatus');
            $table->timestamps();

            // Creates the foreign key constrainst for column variation_id, gender, size, productStatus, status , lease take not that this migration should below the migration of the tables that we will be using as a primary key 
           
            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('gender')->references('id')->on('genders');
            $table->foreign('size')->references('id')->on('sizes');
            $table->foreign('productStatus')->references('id')->on('product_status');
            $table->foreign('status')->references('id')->on('status');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

