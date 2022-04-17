<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Preferred Domain / Canonical Domain
    |--------------------------------------------------------------------------
    | Example: https://www.example.com (www), https://example.com (non-www)
    |
    | Available Mode: "//www.", "//"
     */

    'preferred' => env('APP_PREFERRED_DOMAIN_WWW', '//'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Protocol
    |--------------------------------------------------------------------------
    |
    | Available Mode: "http://", "https://"
     */

    'protocol' => env('APP_PREFERRED_DOMAIN_PORTOCOL','http://'),
];