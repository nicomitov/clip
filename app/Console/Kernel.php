<?php

namespace App\Console;


use App\Schedule\SendDN;
use App\Schedule\SendClip;
use App\Schedule\DeactivateClients;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // $schedule->job(new DeactivateClients)
        //             ->dailyAt('20:17');

        // $schedule->call(new DeactivateClients)
        //          ->withoutOverlapping()
        //          ->everyMinute();
        //          ->dailyAt('20:46');

        $schedule->call(new SendDN)
                 ->name('dn')
                 ->withoutOverlapping()
                 ->everyMinute();
                 // ->dailyAt('20:46');

        $schedule->call(new SendClip)
                 ->name('clip')
                 ->withoutOverlapping()
                 ->everyMinute();
                 // ->dailyAt('20:46');
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
