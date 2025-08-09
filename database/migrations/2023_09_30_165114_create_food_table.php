<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void {
        Schema::create('food' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger('food_category_id')
                  ->nullable();
            $table->string('title');
            $table->float('calorie')
                  ->default(0);
            $table->float('carbohydrate')
                  ->default(0);
            $table->float('fat')
                  ->default(0);
            $table->float('protein')
                  ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void {
        Schema::dropIfExists('food');
    }
};
