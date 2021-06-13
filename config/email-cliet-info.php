<?php

return [
    'from' => env('EMAIL_FROM'),
    'mailjet' => [
        'url' => env('MAILJET_URL'),
        'apiKey' => env('MAILJET_API_KEY'),
        'secretKey' => env('MAILJET_SECRET_KEY'),
    ]
];
