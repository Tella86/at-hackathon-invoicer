<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ✅ Added Africa's Talking
    'africastalking' => [
        'username'     => env('AFRICASTALKING_USERNAME', 'ezems-hotspot'),
        'api_key'      => env('AFRICASTALKING_API_KEY', 'atsk_e19dbf8a03ae1927856a3a8cbbd8508a2bf01c05d81a07490738d12572e0a6a65a7bcb7e'),
        'product_name' => env('AFRICASTALKING_PRODUCT_NAME', 'AFRICASTALKING'),
    ],

];
