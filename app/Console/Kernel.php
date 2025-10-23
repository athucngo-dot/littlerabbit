<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Run cron job to daily delete recently_viewed records older than 90 days
        // at 1 AM
        $schedule->command('recently-viewed:clean-old')->dailyAt('01:00');

        // Run cron job to daily delete cart items records older than 180 days
        // at 2 AM
        $schedule->command('cart-items:clean-old')->dailyAt('02:00');
    }
}
