<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:update-status-kitchen')->everyTwoHours()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:update-status-machine')->everyTwoHours()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:update-status-room')->hourly()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:banned-user-sergun')->hourly()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:banned-user-kitchen')->hourly()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:banned-user-machine')->hourly()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:banned-user-theater')->hourly()->timezone('Asia/Jakarta')->runInBackground();
        $schedule->command('app:banned-user-c-w-s')->hourly()->timezone('Asia/Jakarta')->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
