<?php

namespace App\Console;

use App\Console\Commands\SendBirthdayGreetings;
use App\Console\Commands\SendBirthdayHoliday;
use App\Console\Commands\SendBirthdayHolidayLost;
use App\Console\Commands\SendPaidHoliday;
use App\Console\Commands\SendPaidHolidayLost;
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
        SendBirthdayGreetings::class,
        SendBirthdayHoliday::class,
        SendBirthdayHolidayLost::class,
        SendPaidHoliday::class,
        SendPaidHolidayLost::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:list')->dailyAt('9:00');
        $schedule->command('log:clean')->daily(); # 古いログ削除
        $schedule->command('send:birthday-greetings')->dailyAt('09:00'); # 毎朝9:00にバースデー通知
        $schedule->command('send:birthday-holiday')->dailyAt('09:00'); # 毎朝9:00に実行
        $schedule->command('send:birthday-holiday-lost')->dailyAt('09:00'); # 毎朝9:00に実行
        $schedule->command('send:paid-holiday')->yearlyOn(3, 1, '09:00'); # 毎年3月1日に実行
        $schedule->command('send:paid-holiday-lost')->yearlyOn(3, 1, '09:00'); # 毎年3月1日に実行

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
