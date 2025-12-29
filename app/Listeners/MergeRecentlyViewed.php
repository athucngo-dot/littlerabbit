<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class MergeRecentlyViewed
{

    protected static $hasRun = false;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        //prevent being called multitimes
        //somehow it triggers this handle twice
        if (self::$hasRun) {
            return;
        }

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            // not a front-end customer, skip
            self::$hasRun = true;
            return;
        }

        ProductService::addOrUpdateRecentlyViewedToDB();

        self::$hasRun = true;
    }
}
