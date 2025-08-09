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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->dateTime('premium_expires_at')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('sex')->nullable();
            $table->boolean('pregnant_status')->nullable();
            $table->boolean('lactation_status')->nullable();
            $table->string('birthday')->nullable();
            $table->string('exercise')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('goal')->nullable();
            $table->timestamp('register_completed_at')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
