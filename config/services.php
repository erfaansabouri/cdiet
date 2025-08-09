<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN') ,
        'secret' => env('MAILGUN_SECRET') ,
        'endpoint' => env('MAILGUN_ENDPOINT' , 'api.mailgun.net') ,
        'scheme' => 'https' ,
    ] ,
    'postmark' => [
        'token' => env('POSTMARK_TOKEN') ,
    ] ,
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID') ,
        'secret' => env('AWS_SECRET_ACCESS_KEY') ,
        'region' => env('AWS_DEFAULT_REGION' , 'us-east-1') ,
    ] ,
    'google' => [
        'client_id' => 'xxxx' ,
        'client_secret' => 'xxx' ,
        'redirect' => 'http://127.0.0.1:8000/callback/google' ,
    ] ,
    'myket' => [
        'package_name' => env('MYKET_PACKAGE_NAME' , 'com.xeniac.caloriediet') ,
        'x_access_token' => env('MYKET_X_ACCESS_TOKEN' , 'b8feb29d-7a98-4674-8a03-a70c848f20a2') ,
    ] ,
    'bazaar' => [
        'package_name' => env('BAZAAR_PACKAGE_NAME' , 'com.xeniac.caloriediet') ,
    ] ,
];
