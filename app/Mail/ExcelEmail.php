<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExcelEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $excelFilePath;
    protected $yesterday;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($excelFilePath)
    {
        $this->excelFilePath = $excelFilePath;
        $this->yesterday = Carbon::yesterday()->format('Y-m-d');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.toList', ['yesterday' => $this->yesterday])
            ->attach($this->excelFilePath, [
                'as' => 'excel_file.xlsx',
                'mime' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
