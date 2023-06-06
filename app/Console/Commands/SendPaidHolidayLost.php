<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendPaidHolidayLost extends Command
{
    protected $signature = 'send:paid-holiday-lost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaidHolidayLostAlert sending';

    public function handle()
    {
        /** 有給休暇が失効するユーザーを抽出 */
        $all_users = User::all();
        $users = $all_users->filter(function ($user)
        {
            return $user->lost_paid_holidays > 0;
        });

        foreach ($users as $user) {
            $lost_paid_holidays = $user->lost_paid_holidays;
            Mail::send(
                'mail.paidHolidayLost',
                ['name' => $user->name, 'lost_paid_holidays' => $lost_paid_holidays],
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('有給休暇の失効予告');
                }
            );
        }

        $this->info('Paid holiday lost sent successfully.');
    }
}
