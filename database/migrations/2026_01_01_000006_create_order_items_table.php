<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One row per ordered line, for the whole life of that line.
     *
     * This is the table that replaces the physical move between
     * product_on_process and product_on_return_cancel. Each move was a
     * create() plus a delete() with no transaction, spread over three
     * controllers that had already drifted: `total` was price × quantity in
     * moveProduct but bare `price` in four of six moveMultiple arms, and one
     * arm wrote to OnHand while its label said cancel.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Nullable so deleting a catalog product cannot erase the history
            // of it having been sold.
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Snapshotted at purchase. Editing or deleting the catalog product
            // afterwards must not rewrite what the customer actually bought.
            $table->string('description');
            $table->string('image_path')->nullable();
            $table->string('variation');
            $table->string('gender');
            $table->string('size');
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('line_total', 12, 2);

            $table->string('status')->default('to_pay');
            $table->string('cancel_reason')->nullable();
            $table->string('cancel_note')->nullable();
            $table->timestamps();

            // Both the admin lifecycle screens and the customer's purchase tabs
            // are a filter on this column.
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
