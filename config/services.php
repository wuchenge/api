<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'aliyun' => [
        'access_key_id' => env('ACCESS_KEY_ID'),
        'access_key_secret' => env('ACCESS_KEY_SECRET'),
        'sign_name' => env('SIGN_NAME'),
        'captcha_delay' => env('CAPTCHA_DELAY'),
        'captcha_expire' => env('CAPTCHA_EXPIRE'),
    ],

    'my' => [
        'no_verify_phone' => env('NO_VERIFY_PHONE', ''),
        'api_default_language' => env('API_DEFAULT_LANGUAGE', 'zh_CN'),
        'api_default_message' => env('API_DEFAULT_MESSAGE', ''),
        'app_login_type' => explode(',', env('APP_LOGIN_TYPE', ''))
    ]

];
