<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\CartService;

class MergeGuestCart
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

        CartService::addOrUpdateGuestCartToDB();

        self::$hasRun = true;
    }
}
