<?php

return [
    /*
    |--------------------------------------------------------------------------
    | License API Configuration
    |--------------------------------------------------------------------------
    */

    'api_url' => env('LICENSE_API_URL', 'https://octosyncsoftware.com/api'),
    'license_key' => env('LICENSE_KEY'),

    'cache' => [
        'duration' => 6, // hours
        'key' => 'license_status',
    ],

    'grace_period' => [
        'enabled' => true,
        'days' => 7,
    ],

    'warnings' => [
        'days_before_expiry' => [30, 15, 7, 3, 1],
        'show_banner' => true,
    ],

    // Define which route patterns require license checks
    'protected_routes' => [
        // These routes will be blocked if license is invalid
        'block_access' => [
            'admin/*',
            'admin',
            'admin/dashboard',
            'admin/orders*',
            'admin/products*',
            'admin/categories*',
            'admin/brands*',
            'admin/attributes*',
            'admin/reviews*',
            'admin/deals*',
            'admin/expense*',
            'admin/settings*',
            'admin/carousels*',
            'admin/subscribers*',
        ],

        // These routes will show warnings but allow access
        'show_warnings' => [
            '/',
            'search*',
            'cart*',
            'checkout*',
            'products*',
            'brands*',
            'categories*',
            'featured-products*',
            'deals*',
            'about',
            'contact*',
            'privacy-policy',
            'terms-of-service',
            'return-policy',
        ],
    ],

    'features' => [
        'block_on_expired' => true,
        'allow_public_access' => true,
        'notify_admin' => true,
    ],
];