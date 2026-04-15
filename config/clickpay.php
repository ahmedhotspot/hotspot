<?php

return [
    'profile_id'   => env('CLICKPAY_PROFILE_ID'),
    'server_key'   => env('CLICKPAY_SERVER_KEY'),
    'request_url'  => env('CLICKPAY_REQUEST_URL', 'https://secure.clickpay.com.sa/payment/request'),
    'query_url'    => env('CLICKPAY_QUERY_URL', 'https://secure.clickpay.com.sa/payment/query'),
    'currency'     => env('CLICKPAY_CURRENCY', 'SAR'),
    'fee_amount'   => env('CLICKPAY_FEE_AMOUNT', 100),
    'callback_url' => env('CLICKPAY_CALLBACK_URL'),
    'return_url'   => env('CLICKPAY_RETURN_URL'),
];
