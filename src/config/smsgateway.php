<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS Gateway Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the sms gateway provider connections below you wish
    | to use as your default connection for all SMS work. Of course
    | you may use many connections at once by overriding connection name on the 
    | object initialization.
    |
    */
    'default' => env('SMS_CONNECTION', null),
    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | List of valid SMS Connections
    |
    */
    'connection' => [
        /*
        |--------------------------------------------------------------------------
        | M360
        |--------------------------------------------------------------------------
        |
        | M360 variables
        |
        */
        'm360' => [
            'url' => env('M360_BASEURI', null),
            'app_key' => env('M360_APP_KEY', null),
            'app_secret' => env('M360_APP_SECRET', null),
            'shortcode_mask' => env('M360_SENDER_ID', null),
        ],
        /*
        |--------------------------------------------------------------------------
        | PROMOTEXTER
        |--------------------------------------------------------------------------
        |
        | PROMOTEXTER variables
        |
        */
        'promotexter' => [
            'url' => env('PROMOTEXTER_BASEURI', null),
            'from' => env('PROMOTEXTER_FROM', null),
            'apiKey' => env('PROMOTEXTER_APIKEY', null),
            'apiSecret' => env('PROMOTEXTER_APISECRET', null),
        ],
    ],
];
