<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Cloudinary
    |--------------------------------------------------------------------------
    |
    | Konfigurasi ini secara eksplisit memberikan kredensial ke Cloudinary SDK
    | dalam format array bersarang yang benar.
    |
    */
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', ''),
        'api_key'    => env('CLOUDINARY_API_KEY', ''),
        'api_secret' => env('CLOUDINARY_API_SECRET', ''),
    ],

    'url' => [
        'secure' => true,
    ],
];