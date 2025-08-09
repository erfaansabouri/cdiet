<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void {
        Schema::create('admins' , function ( Blueprint $table ) {
            $table->id();
            $table->string('name')
                  ->nullable()
                  ->default('Admin');
            $table->string('email')
                  ->nullable();
            $table->string('password')
                  ->nullable();
            $table->string('remember_token')
                  ->nullable();
            $table->timestamps();
        });
        \App\Models\Admin::create([
                                      'name' => 'Admin' ,
                                      'email' => 'admin@mail.com' ,
                                      'password' => bcrypt('as12AS!@') ,
                                  ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void {
        Schema::dropIfExists('admins');
    }
};
