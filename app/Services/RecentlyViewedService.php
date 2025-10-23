<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\RecentlyViewed;

class RecentlyViewedService
{
    /**
     * Trim old recently viewed records for a customer, 
     * keeping only the most recent ones.
     */
    public static function trimOldViews($customerId)
    {
        $keep = config('site.max_recently_viewed_stored', 20);

        $idsToKeep = RecentlyViewed::where('customer_id', $customerId)
            ->orderByDesc('viewed_at')
            ->take($keep)
            ->pluck('id');

        if ($idsToKeep->isNotEmpty()) {
            RecentlyViewed::where('customer_id', $customerId)
                ->whereNotIn('id', $idsToKeep)
                ->delete();
        }
    }
}
