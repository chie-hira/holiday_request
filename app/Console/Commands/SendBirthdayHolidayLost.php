<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendBirthdayHolidayLost extends Command
{
    protected $signature = 'send:birthday-holiday-lost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'birthdayHolidayLostAlert sending';

    public function handle()
    {
        /** 今日が誕生日の1ヶ月後から14日前か判定する日付 */
        $reference_date = Carbon::now()
            ->subMonths(1)
            ->addDays(14)
            ->format('m-d');

        /** バースデイ休暇の取得期間が終わる14日まえのユーザーを取得してmails.birthdayHolidayLostの内容のメールを送信 */
        $users = User::where('birthday', $reference_date)
            ->select('email', 'name', 'birthday')
            ->get();

        // TODO:事務責任者にも同じ通知を送る？
        foreach ($users as $user) {
            $birthday = new Carbon(Carbon::now()->year . '-' . $user->birthday);
            $start =
                $birthday->copy()->subMonths(1)->year .
                '年' .
                $birthday->copy()->subMonths(1)->month .
                '月' .
                $birthday->copy()->subMonths(1)->day .
                '日';
            $end =
                $birthday->copy()->addMonths(1)->year .
                '年' .
                $birthday->copy()->addMonths(1)->month .
                '月' .
                $birthday->copy()->addMonths(1)->day .
                '日';
            Mail::send(
                'mails.birthdayHolidayLost',
                ['name' => $user->name, 'start' => $start, 'end' => $end],
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('バースデイ休暇の失効予告');
                }
            );
        }

        $this->info('Birthday holiday lost sent successfully.');
    }
}
