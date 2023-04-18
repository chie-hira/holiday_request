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
            ['report_id' => 1, 'sub_report_name' => '半日有休'],
            ['report_id' => 1, 'sub_report_name' => '時間休'],
            ['report_id' => 5, 'sub_report_name' => '時間単位'],
            ['report_id' => 6, 'sub_report_name' => '時間単位'],
            ['report_id' => 7, 'sub_report_name' => '時間単位'],
            ['report_id' => 8, 'sub_report_name' => '時間単位'],
        ];
        DB::table('sub_report_categories')->insert($param);
    }
}
