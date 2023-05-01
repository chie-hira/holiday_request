<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ReportCategory;

class RemainingSeeder extends Seeder
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
            $report_ids = [1, 2, 3, 5, 6, 7, 8, 14];

            foreach ($report_ids as $report_id) {
                $report_category = ReportCategory::find($report_id);
                $param[] = [
                    'user_id' => $user_id,
                    'report_id' => $report_id,
                    'remaining' => $report_category->max_days,
                ];
            }
        }

        DB::table('remainings')->insert($param);
    }
}
