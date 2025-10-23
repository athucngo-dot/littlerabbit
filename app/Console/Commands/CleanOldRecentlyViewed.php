<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecentlyViewed;
use Carbon\Carbon;

class CleanOldRecentlyViewed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recently-viewed:clean-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete recently_viewed records older than 90 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateCutoff = Carbon::now()->subDays(90);

        // Delete records older than the dateCutoff date (90 days)
        $deleted = RecentlyViewed::where('viewed_at', '<', $dateCutoff)->delete();

        $this->info("Deleted {$deleted} Recently Viewed records older than 90 days.");

        return 0;
    }
}
