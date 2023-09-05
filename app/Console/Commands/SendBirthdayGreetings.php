<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendBirthdayGreetings extends Command
{
    protected $signature = 'send:birthday-greetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'birthdayGreetingMail sending';

    public function handle()
    {
        $today = Carbon::now()->format('m-d');

        // FIXME:うるう年問題 2月29日生まれの人には未通知
        /** 今日、誕生日のユーザーを取得してmails.birthdayの内容のメールを送信 */
        // $users = User::whereRaw(
        //     "DATE_FORMAT(STR_TO_DATE(birthday, '%m-%d'), '%m-%d') = '$today'"
        // )
        $users = User::where('birthday', $today)
            ->select('email', 'name')
            ->get();

        foreach ($users as $user) {
            Mail::send(
                'mails.birthday',
                ['name' => $user->name],
                function ($message) use ($user) {
                    $message->to($user->email)->subject('Happy Birthday!');
                }
            );
        }

        $this->info('Birthday greetings sent successfully.');
    }
}
