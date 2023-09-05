<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:available';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'available to all users sending';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** 有給休暇が失効するユーザーを取得してmails.paidHolidayLostの内容のメールを送信 */
        $users = User::all();
        $url = route('menu');
        // $explanations_url = route('explanations');

        foreach ($users as $user) {
            Mail::send(
                'mails.available',
                [
                    'name' => $user->name,
                    'employee' => $user->employee,
                    'password' => $user->remarks,
                    'url' => $url,
                    // 'explanations_url' => $explanations_url,
                ],
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('休暇申請アプリへようこそ');
                }
            );

            $user->remarks = null; // 備考欄のパスワードを削除
            $user->save();

            // 送信間隔を設定（スパム検知防止）
            sleep(5); // 5秒待機
        }

        $this->info('Available mails sent successfully.');
    }
}
