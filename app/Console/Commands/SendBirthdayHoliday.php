<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendBirthdayHoliday extends Command
{
    protected $signature = 'send:birthday-holiday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'birthdayHolidayMail sending';

    public function handle()
    {
        $reference_date = Carbon::now()
            ->addMonths(3)
            ->format('m-d');

        $users = User::whereRaw(
            "DATE_FORMAT(STR_TO_DATE(birthday, '%m-%d'), '%m-%d') = '$reference_date'"
        )
            ->select('email', 'name', 'birthday')
            ->get();

        foreach ($users as $user) {
            $birthday = new Carbon(Carbon::now()->year . '-' . $user->birthday);
            $start =
                $birthday->copy()->subMonths(3)->year .
                '年' .
                $birthday->copy()->subMonths(3)->month .
                '月' .
                $birthday->copy()->subMonths(3)->day .
                '日';
            $end =
                $birthday->copy()->addMonths(3)->year .
                '年' .
                $birthday->copy()->addMonths(3)->month .
                '月' .
                $birthday->copy()->addMonths(3)->day .
                '日';
            Mail::send(
                'mail.birthdayHoliday',
                ['name' => $user->name, 'start' => $start, 'end' => $end],
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('バースデイ休暇取得期間');
                }
            );
        }

        $this->info('Birthday holiday notice sent successfully.');
    }
}
