<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('dietary_cooking_categories' , function ( Blueprint $table ) {
            $table->id();
            $table->string('title')
                  ->nullable();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('dietary_cooking_categories');
    }
};
