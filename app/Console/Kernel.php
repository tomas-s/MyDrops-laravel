<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Sensor;
use App\Http\Controllers\NotificationController;
use DateTime;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            $date = new DateTime;
            $date->modify('-30 minutes');
            $formatted_date = $date->format('Y-m-d H:i:s');
            
            $sensors = Sensor::where('updated_at','<=',$formatted_date)->get();
            
            foreach ($sensors as $sensor){
                NotificationController::notify_user($sensor, 'email', 'lost_contact'); 
            }
        })->dailyAt('18:00');
    }

}
