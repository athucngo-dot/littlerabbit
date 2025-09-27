<?php

namespace App\Listeners;

//use IlluminateAuthEventsLogin;
use Illuminate\Auth\Events\Login;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cart;

class MergeGuestCart
{
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
    /*public function handle(IlluminateAuthEventsLogin $event): void
    {
        //
    }*/

    public function handle(Login $event): void
    {
        $customerId = $event->user->id;
        $sessionId = session()->getId();

        // Fetch guest cart items
        $guestCartItems = Cart::where('session_id', $sessionId)->get();

        foreach ($guestCartItems as $item) {
            // Check if the customer already has the same product/color/size
            $existing = Cart::where('customer_id', $customerId)
                ->where('product_id', $item->product_id)
                ->where('color_id', $item->color_id)
                ->where('size_id', $item->size_id)
                ->first();

            if ($existing) {
                // Merge quantities
                $existing->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                // Reassign the guest item to the customer
                $item->customer_id = $customerId;
                $item->session_id = null;
                $item->save();
            }
        }
    }
}
