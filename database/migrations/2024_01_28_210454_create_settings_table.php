<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void {
        Schema::create('settings' , function ( Blueprint $table ) {
            $table->id();
            $table->string('bazaar_access_token')
                  ->nullable();
            $table->timestamp('bazaar_access_token_updated_at')
                  ->nullable();
            $table->timestamp('bazaar_sms_sent_at')
                  ->nullable();
            $table->timestamps();
        });
        Setting::query()
               ->create([
                            'bazaar_access_token' => 'v99jejCIR1LDlh55RGLXq4PtCgaYgf' ,
                            'bazaar_access_token_updated_at' => now() ,
                            'bazaar_sms_sent_at' => now(),
                        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void {
        Schema::dropIfExists('settings');
    }
};
