<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:test-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail test';

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
        // $users = User::all();
        $users = User::where('employee', 999)->get();
        // $url = route('menu');
        // $explanations_url = route('explanations');

        foreach ($users as $user) {
            Mail::send(
                'mails.testing',
                [
                    'name' => $user->name,
                    'employee' => $user->employee,
                    // 'password' => $user->remarks,
                    // 'url' => $url,
                    // 'explanations_url' => $explanations_url,
                ],
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('テストメール');
                }
            );

            // $user->remarks = null; // 備考欄のパスワードを削除
            // $user->save();
        }

        $this->info('Test mails sent successfully.');
    }
}
