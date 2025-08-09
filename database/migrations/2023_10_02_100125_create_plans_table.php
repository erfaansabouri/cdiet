<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void {
        Schema::create('plans' , function ( Blueprint $table ) {
            $table->id();
            $table->string('myket_plan_id')
                  ->nullable();
            $table->string('bazaar_plan_id')
                  ->nullable();
            $table->integer('days')
                  ->default(0);
            $table->string('text_1')
                  ->nullable();
            $table->string('text_2')
                  ->nullable();
            $table->string('text_3')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void {
        Schema::dropIfExists('plans');
    }
};
