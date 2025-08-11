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
        Schema::table('mealtimes', function (Blueprint $table) {
            $table->boolean('for_pregnant')->default(false);
            $table->boolean('for_lactation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mealtimes', function (Blueprint $table) {
            //
        });
    }
};
