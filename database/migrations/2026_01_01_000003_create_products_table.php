<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The catalog. Replaces `product_on_hand` and also the old `products`
     * table, which was not a catalog at all — it was a denormalised copy a row
     * was pushed into at review time so `feedback.productId` had something to
     * point at.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->string('description');
            $table->string('variation');
            $table->string('gender');
            $table->string('size');

            // Every money column in the old schema was int(11) while
            // UserController cast to (float) on the way in, so centavos were
            // truncated on write without an error.
            $table->decimal('price', 12, 2);

            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            // The storefront filter queries exactly these three together.
            $table->index(['variation', 'gender', 'size']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
