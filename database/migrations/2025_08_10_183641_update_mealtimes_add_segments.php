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
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->string('goal')->nullable();
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
