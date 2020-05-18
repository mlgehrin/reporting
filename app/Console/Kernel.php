<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendReminderForSelfReflection;
use App\Console\Commands\SendReminderForPeerCollection;
use App\Console\Commands\SendReminderForPeerReflection;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendReminderForSelfReflection::class,
        SendReminderForPeerCollection::class,
        SendReminderForPeerReflection::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:selfReflectionReminder')->cron('0 20 */2 * *');
        $schedule->command('send:peerCollectionReminder')->cron('0 20 */2 * *');
        $schedule->command('send:peerReflectionReminder')->cron('0 20 */2 * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
