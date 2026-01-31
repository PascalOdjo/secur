<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Run the payment processor every minute to catch vacations that ended
        $schedule->command('payments:process-daily')->everyMinute();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
