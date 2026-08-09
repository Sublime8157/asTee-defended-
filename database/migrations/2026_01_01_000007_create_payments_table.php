<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replaces `payment_history`. `provider_ref` is unique so the Phase 4
     * PayMongo webhook can be made idempotent by insert rather than by a
     * read-then-write that races with a retry.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('manual');
            $table->string('provider_ref')->nullable()->unique();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('paid');

            // Bank transfer screenshots. Phase 2b moves these to the private
            // disk — under the old code they landed in storage/app/public
            // under the uploader's own filename and were world-readable.
            $table->string('proof_path')->nullable();

            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
