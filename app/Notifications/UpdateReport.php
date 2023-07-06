<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Report;

class UpdateReport extends Notification
{
    use Queueable;
    public $user_name;
    public $report_id;
    public $report_category;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $am_pm;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->user_name = $report->user->name;
        $this->report_id = $report->id;
        $this->report_category = $report->report_category->report_name;
        $this->start_date = $report->start_date;
        $this->end_date = $report->end_date;
        $this->start_time = $report->start_time;
        $this->end_time = $report->end_time;
        $this->am_pm =
            $report->am_pm == 1 ? '前半' : ($report->am_pm == 2 ? '後半' : '');
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
        $url = route('reports.show', $this->report_id);
        return (new MailMessage())
            ->subject('申請が更新されました')
            ->markdown('mails.updateReport', [
                'user_name' => $this->user_name,
                'report_category' => $this->report_category,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'am_pm' => $this->am_pm,
                'url' => $url,
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
