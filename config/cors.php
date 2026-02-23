<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Ovaj fajl definiše kako tvoj API odgovara na zahteve sa drugih domena.
    | Ovde navodimo port na kojem radi tvoj frontend (React, Vite, itd.)
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'reset-password'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        "*"
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
