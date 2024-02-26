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
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('gender');
            $table->tinyInteger('size');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->tinyInteger('status');
            $table->tinyInteger('productStatus');
            $table->timestamps();

            
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

