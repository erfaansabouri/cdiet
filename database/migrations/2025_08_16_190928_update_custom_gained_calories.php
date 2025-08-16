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
        Schema::table('custom_gained_calories', function (Blueprint $table) {
            $table->integer('fat')->default(0);
            $table->integer('protein')->default(0);
            $table->integer('carbohydrate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_gained_calories', function (Blueprint $table) {
            //
        });
    }
};
