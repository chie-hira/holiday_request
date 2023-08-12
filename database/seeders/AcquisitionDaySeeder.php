<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ReportCategory;

class AcquisitionDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $param = [];

        for ($i=0; $i < count($users) ; $i++) { 
            $user_id = $users[$i]->id;
            // $report_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 16];
            $report_categories = ReportCategory::all();

            // foreach ($report_ids as $report_id) {
            foreach ($report_categories as $report) {
                $param[] = [
                    'user_id' => $user_id,
                    'report_id' => $report->id,
                    'remaining_days' => $report->max_days,
                ];
            }
        }

        DB::table('acquisition_days')->insert($param);
    }
}
