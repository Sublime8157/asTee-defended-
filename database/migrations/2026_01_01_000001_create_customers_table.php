<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->date('birthday');
            $table->string('address');
            $table->string('email')->unique();

            // Was bigint(20). A Philippine mobile number is written 09171234567
            // and an integer column silently eats the leading zero.
            $table->string('contact', 20)->nullable();

            $table->string('username')->unique();
            $table->string('password');

            // Replaces `userStatus` (1 = active, 2 = blocked) and its
            // `user_status` lookup table, and `verification`
            // (enum not_verified/verified) for the valid-ID review.
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('id_verified_at')->nullable();
            $table->string('valid_id_path')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
