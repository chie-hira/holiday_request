<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 年度末にリセット
        $param = [
            ['report_name' => '有給休暇', 'max_days' => 40, 'max_times' => null], # 半日有給、時間休も含む
            ['report_name' => 'バースデイ休暇', 'max_days' => 1, 'max_times' => 1],
            ['report_name' => '特別休暇(慶事)', 'max_days' => 5, 'max_times' => null],
            ['report_name' => '特別休暇(弔事)', 'max_days' => null, 'max_times' => null],
            ['report_name' => '特別休暇(看護・対象1人)', 'max_days' => 5, 'max_times' => null], # 時間単位
            ['report_name' => '特別休暇(看護・対象2人以上)', 'max_days' => 10, 'max_times' => null], # 時間単位
            ['report_name' => '特別休暇(介護・対象1人)', 'max_days' => 5, 'max_times' => null], # 時間単位
            ['report_name' => '特別休暇(介護・対象2人以上)', 'max_days' => 10, 'max_times' => null], # 時間単位
            ['report_name' => '特別休暇(短期育休)', 'max_days' => 5, 'max_times' => null], # 1日単位
            ['report_name' => '欠勤', 'max_days' => null, 'max_times' => null],
            ['report_name' => '遅刻', 'max_days' => null, 'max_times' => null],
            ['report_name' => '早退', 'max_days' => null, 'max_times' => null],
            ['report_name' => '外出', 'max_days' => null, 'max_times' => null],
            ['report_name' => '介護休業', 'max_days' => 93, 'max_times' => 3], # 対象家族1人につき
            ['report_name' => '育児休業', 'max_days' => null, 'max_times' => null],
            ['report_name' => 'パパ育休', 'max_days' => 28, 'max_times' => null],
        ];
        DB::table('report_categories')->insert($param);
    }
}
