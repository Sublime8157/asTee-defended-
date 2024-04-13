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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('productId');
            $table->string('address');
            $table->bigInteger('contact');
            $table->enum('mop', ['cash_on_delivery','online_payment'])->default('online_payment');
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
        Schema::dropIfExists('orders');
    }
};
