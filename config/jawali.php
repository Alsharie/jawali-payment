<?php


return [
    'auth' => [
        'phone' => env('JAWALI_MERCHANT_PHONE'),
        'username' => env('JAWALI_MERCHANT_USERNAME'),
        'password' => env('JAWALI_MERCHANT_PASSWORD'),
        
        'org_id' => env('JAWALI_MERCHANT_ORG_ID'),
        'user_id' => env('JAWALI_MERCHANT_USER_ID'),
        'external_user' => env('JAWALI_MERCHANT_EXTERNAL_USER'),

        'wallet' => env('JAWALI_MERCHANT_WALLET'),
        'wallet_password' => env('JAWALI_MERCHANT_WALLET_PASSWORD'),
    ],
    'url' => [
        'base' => env('JAWALI_BASE_URL', 'https://82.114.179.89:9493/paygate'),
    ]
];
