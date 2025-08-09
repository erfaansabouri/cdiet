<?php

namespace App\Helpers;

use App\Models\Article;
use App\Models\Diet;
use App\Models\DietaryCooking;
use App\Models\Exercise;
use App\Models\FoodUnit;
use App\Models\HomeMenuItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Util {
    public function standardPhoneNumber ( $phone_number ) {
        if ( strlen($phone_number) === 10 and substr($phone_number , 0 , 1) != 0 ) {
            $phone_number = Str::start($phone_number , 0);
        }

        return $phone_number;
    }

    public function simpleSuccess ( $message ) {
        return response()->json([
                                    'status' => true ,
                                    'message' => $message ,
                                ]);
    }

    public function throwError ( $message ) {
        throw ValidationException::withMessages([
                                                    'error' => $message ,
                                                ]);
    }

    public function toDiscord ( $message ) {
        /*$webhook = 'https://discord.com/api/webhooks/1154073702678417418/kk-ONn5aadq12GpO0t_4sylOZ_b5XgAvbsrSzqFOfh_aUa_eCYz9Rzg7e6Xk8eoemIE6';
        Http::post($webhook , [
            'content' => $message ,
        ]);*/
    }

    public function bazaarAccessToken () {
        $setting = Setting::query()->first();
        return $setting->bazaar_access_token;
    }

    public function toSms ( $phone_number , $text ) {

        Http::get('https://api.sms-webservice.com/api/V3/SendTokenSingle?ApiKey=45674-fbcd4e071efd469cbb4afe86bf3abbfd&TemplateKey=caloriedietlogin&P1='.$text.'&Destination=' . $phone_number);
    }
}


//access_token	"PFkscRAPijD2frL4LN165DbDltw3rO"
//expires_in	3600000
//token_type	"Bearer"
//scope	"androidpublisher"
//refresh_token	"7QuEnvHultk1uaolGDTLnHNZJMHaxG"
