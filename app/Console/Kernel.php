<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Mail\EMSMail;

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
         $schedule->call('App\Http\Controllers\ScheduleController@punchmiss')->dailyAt('11:00')->runInBackground();			 
		 $schedule->call('App\Http\Controllers\ScheduleController@processQueue')->runInBackground();
		 $schedule->call('App\Http\Controllers\ScheduleController@markattendance')->dailyAt('0:05')->runInBackground();
         $schedule->call('App\Http\Controllers\ScheduleController@autoUpdate')->dailyAt('0:10')->runInBackground();
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
