<?php

namespace App\Console\Commands;

use App\Exports\ReportExport;
use App\Exports\ReportList;
use App\Mail\ExcelEmail;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SendListToManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ReportList sending';

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
        $yesterday = Carbon::yesterday();
        $start_datetime = $yesterday->addHour(8);
        $today = Carbon::now();
        $end_datetime = $today->addHour(8);
        $report = Report::where('approved', 1)
            ->where('cancel', 0)
            ->where('updated_at', '>=', $start_datetime)
            ->where('updated_at', '<=', $end_datetime)
            ->get();
        $excelData = []; // Excelデータを格納する配列

        foreach ($report as $item) {
            // 加工処理と$excelDataへのデータ追加
            $excelRow = [
                'affiliation' => $item->user->affiliation_name,
                'employee' => $item->user->employee,
                'user_name' => $item->user->name,
                'report_name' => $item->report_category->report_name,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'start_time' => $item->start_time,
                'end_time' => $item->end_time,
                'am_pm' => $item->am_pm == 1 ? '前半' : '後半',
                'acquisition_days' => $item->acquisition_days,
                'acquisition_hours' => $item->acquisition_hours,
                'acquisition_minutes' => $item->acquisition_minutes,
                'shift' => $item->shift_category->shift_code,
                'report_date' => $item->report_date,
                'reason' => $item->reason_category->reason,
                'detail' => $item->reason_detail,
            ];
            $excelData[] = $excelRow;
        }

        // Excelファイルを生成
        $excelFilePath = storage_path('app/excels/file.xlsx');
        Excel::store(new ReportList($excelData), $excelFilePath);

        $users = User::whereHas('approvals', function ($query) {
            $query->where('approval_id', 5);
        })->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ExcelEmail($excelFilePath),);
        }

        $this->info('Report list sent successfully.');
    }
}
