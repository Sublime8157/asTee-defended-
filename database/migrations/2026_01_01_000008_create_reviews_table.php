<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replaces `feedback`, whose `productId` pointed at the throwaway row that
     * submitReview inserted into the old `products` table rather than at
     * anything the customer had bought. It now hangs off the order line, which
     * is also what makes "one review per purchased line" expressible.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('order_item_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating_overall');
            $table->unsignedTinyInteger('rating_quality');
            $table->unsignedTinyInteger('rating_service');
            $table->string('comment')->nullable();
            $table->string('image_path')->nullable();

            // Was `featured` int(11), where the homepage query looked for the
            // value 2 and the insert always wrote 1.
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
