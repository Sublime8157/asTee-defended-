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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->nulalble();
            $table->unsignedBigInteger('productId')->nulalble();
            $table->integer('starCount');
            $table->string('content');
            $table->timestamps();
            
            $table->foreign('userId')->references('id')->on('customers');
            $table->foreign('productId')->references('id')->on('product_on_process');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
