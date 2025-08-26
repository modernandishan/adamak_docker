<?php

return [
    'api_key' => env('IPPANEL_API_KEY'),
    'origin_number' => env('IPPANEL_ORIGIN_NUMBER'),
    'digits' => env('IPPANEL_OTP_DIGITS', 4),
    'patterns' => [
        'login' => env('IPPANEL_LOGIN_PATTERN'),
        'register' => env('IPPANEL_REGISTER_PATTERN'),
        'welcome' => env('IPPANEL_WELCOME_PATTERN'),
        'activated' => env('IPPANEL_ACTIVATED_PATTERN'),
        'deactivated' => env('IPPANEL_DEACTIVATED_PATTERN'),
        'bot_update' => env('IPPANEL_BOT_UPDATE_PATTERN'),
    ],
];
