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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('image_path')->nullable();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->date('birthday');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->unsignedBigInteger('userStatus');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); 
            $table->rememberToken();
            $table->timestamps();
            // address, birthdate not age 
            
            $table->foreign('userStatus')->references('id')->on('user_status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
