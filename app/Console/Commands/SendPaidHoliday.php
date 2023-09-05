<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendPaidHoliday extends Command
{
    protected $signature = 'send:paid-holiday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaidHolidayMail sending';

    public function handle()
    {
        /** 有給休暇の取得日数が5日未満のユーザーを抽出 */
        $users = User::all()->filter(function ($user) {
            return $user->acquisition_paid_holidays < 5;
        });

        foreach ($users as $user) {
            $get_paid_holidays = $user->acquisition_paid_holidays;
            Mail::send(
                'mails.paidHoliday',
                [
                    'name' => $user->name,
                    'get_paid_holidays' => $get_paid_holidays,
                ],
                function ($message) use ($user) {
                    $message->to($user->email)->subject('有給休暇の取得推進');
                }
            );
        }

        $this->info('Paid holiday lost sent successfully.');
    }
}
