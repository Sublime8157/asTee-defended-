<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The old `orders` row held a JSON `productId` array with no foreign key,
     * and checkout created one order per line item while appending to that
     * array — so a three-item basket produced three orders holding [a], [a,b]
     * and [a,b,c]. Lines now live in `order_items`.
     *
     * `sales` is gone with it: a sale was an order with money against it, which
     * is `whereNotNull('paid_at')`, not a second table kept in step by hand.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('customers')->cascadeOnDelete();
            $table->string('address');
            $table->string('contact', 20);
            $table->string('payment_method')->default('online_payment');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // The dashboard groups orders by month and the payment screen
            // filters by date range.
            $table->index('created_at');
            $table->index('paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
