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

    'items_per_page' => 30, // Number of items to display per page for pagination
    'items_per_page_4_per_rows' => 32, // Number of items per page for 4 items per row grid

    // logo and favicon paths
    'logo' => '/images/logo.png',
    'logo_footer' => '/images/logo_footer.png',
    'favicon' => '/images/favicon.ico',

    'default_product_image' => '/images/default_img.png',
    'max_related_product' => 20,
    'max_recently_viewed_stored' => 20, // maximum recently viewed products to store
    
    'recently_viewed_session_key' => 'recently_viewed',

    'cache_time_out' => 3600, //cache time out in 1 hour

    // Cart settings
    'cart' => [
        'cookies_guest_cart' => 'guest_cart', // name of guest cart array stored in cookies
        'cookies_guest_cart_timeout' => 10080, // guest cart cookies timeout in minutes for 7 days (60 mins × 24 hours × 7 days)
        'max_quantity' => 10,     // maximum per product in cart
        'free_shipping_threshold' => 50, // free shipping for orders over this amount
        'shipping_rate' => 0.1, // shipping rate as 10% of subtotal for orders below free shipping threshold
    ],

    //customer settings
    'customer' => [
        'max_addresses' => 5, // maximum addresses a customer can store
    ],
];