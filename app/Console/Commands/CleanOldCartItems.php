<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Cart;

class CleanOldCartItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart-items:clean-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete cart items records older than 180 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateCutoff = Carbon::now()->subDays(180);

        // Delete records older than the dateCutoff date (180 days)
        $deleted = Cart::where('updated_at', '<', $dateCutoff)->delete();

        $this->info("Deleted {$deleted} Cart records older than 180 days.");

        return 0;
    }
}
