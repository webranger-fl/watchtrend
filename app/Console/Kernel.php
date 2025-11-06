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
        // $schedule->command('inspire')->hourly();

          //$schedule->command('backup:run')->dailyAt("19:45");
          //$schedule->command('app:store-backup')->dailyAt("19:50");
          // запуск бэкапа бд каждый 3й день
          //$schedule->command('backup:run')->cron("45 19 */3 * *");
          //$schedule->command('app:store-backup')->cron("50 19 */3 * *");

        //$schedule->command('app:gen-sitemap')->daily();
        /*$schedule->command('queue:work --stop-when-empty')
          ->everyMinute()
          ->withoutOverlapping();*/
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
