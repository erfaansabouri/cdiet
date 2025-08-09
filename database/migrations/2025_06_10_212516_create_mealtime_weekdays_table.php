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
        Schema::create('mealtime_weekdays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mealtime_id')->index()->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->string('calorie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mealtime_weekdays');
    }
};
