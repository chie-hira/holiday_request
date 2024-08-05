<?php

namespace App\Console\Commands;

use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetInitialAquisitionDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set initial acquisition days';

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
        // 休暇日数インサート
        $users = User::all();
        $report_categories = ReportCategory::all();
        $chunkSize = 100; // チャンクのサイズ

        foreach ($users as $user) {
            $param = [];

            foreach ($report_categories as $report) {
                $param[] = [
                    'user_id' => $user->id,
                    'report_id' => $report->id,
                    'remaining_days' => $report->max_days,
                ];
            }

            // パラムをバッチサイズごとに分割してインサート
            $chunks = array_chunk($param, $chunkSize);
            foreach ($chunks as $chunk) {
                DB::table('acquisition_days')->insert($chunk);
            }
        }

        $this->info('Set initial acquisition_dates successfully.');
    }
}
