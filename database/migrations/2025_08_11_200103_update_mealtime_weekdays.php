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
        Schema::table('mealtime_weekdays', function (Blueprint $table) {
            $table->float('carbohydrate')
                  ->default(0);
            $table->float('fat')
                  ->default(0);
            $table->float('protein')
                  ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mealtime_weekdays', function (Blueprint $table) {
            //
        });
    }
};
