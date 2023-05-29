<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail sending';

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
        // return 0;
        // echo 'send mail';
        $user = User::first();
        // テキストメールで短文の場合
        // Mail::raw('本文です', function ($message) use ($user) {
            // $message->to($user->email)->subject('タイトルです');
        Mail::raw('本文です', function ($message) {
            $message->to('capella.a36@gmail.com')->subject('タイトルです');
        });
    }
}
