<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration settings for the site.
    | You can adjust these settings as needed.
    |
    */

    'name' => env('APP_NAME', 'Little Rabbit'),

    'items_per_page' => 51, // Number of items to display per page for pagination

    // logo and favicon paths
    'logo' => '/images/logo.png',
    'logo_footer' => '/images/logo_footer.png',
    'favicon' => '/images/favicon.ico',

    'default_product_image' => '/images/default_img.png',

    // Cart settings
    'cart' => [
        'max_quantity' => 10,     // maximum per product in cart
    ],
];