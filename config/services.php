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
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '336715397517903',
        'client_secret' => '18f7f2ec0ef7d2a967e80dcac863240a',
        'redirect' => 'https://bisyor.uz/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '821819369162-trvgs178sgo7b0kibgotk19hpqdk0bik.apps.googleusercontent.com',
        'client_secret' => 'KSJHe4A9AQ1zGrEjFY4DMEeQ',
        'redirect' => 'https://bisyor.uz/auth/google/callback',
    ],

    'yandex' => [
        'client_id' => '51471528608042db90cf4a7810e554d4',
        'client_secret' => '4ce8a37ac2d94537982c4ff3e3066a60',
        'redirect' => 'https://bisyor.uz/auth/yandex/callback',
    ],

];
