<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class BazaarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bazaar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $setting = Setting::query()->first();
        $bazaar_access_token_updated_at = $setting->bazaar_access_token_updated_at;

        // if 30 days passed from last update
        if (now()->diffInDays($bazaar_access_token_updated_at) >= 30) {
            // if 1 day passed from last sms
            if (now()->diffInDays($setting->bazaar_sms_sent_at) >= 1) {
                util()->toSms('09129383123' , 'BZAR');
                $setting->bazaar_sms_sent_at = now();
                $setting->save();
            }
        }
    }
}
