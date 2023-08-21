<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Registered extends Notification
{
    use Queueable;
    public $user_name;
    public $employee;
    public $remarks;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user_name = $user->name;
        $this->employee = $user->employee;
        $this->remarks = $user->remarks;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('menu');
        // $explanations_url = route('explanations');
        return (new MailMessage())
            ->subject('ようこそ休暇申請アプリへ')
            ->markdown('mails.registered', [
                'user_name' => $this->user_name,
                'employee' => $this->employee,
                'password' => $this->remarks,
                'url' => $url,
                // 'explanations_url' => $explanations_url,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
