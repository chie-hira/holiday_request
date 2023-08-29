<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['sub_report_name' => '終日休', 'remarks' => null],
            ['sub_report_name' => '連休', 'remarks' => null],
            ['sub_report_name' => '半日休', 'remarks' => '半日休の前半と後半で日付が異なるシフトの場合、休暇予定日は前半の日付にしてください'],
            ['sub_report_name' => '時間休',  'remarks' => null],
        ];
        DB::table('sub_report_categories')->insert($param);
    }
}
