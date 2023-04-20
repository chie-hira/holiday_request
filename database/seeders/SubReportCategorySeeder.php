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
            ['sub_report_name' => '終日休'],
            ['sub_report_name' => '半日有休'],
            ['sub_report_name' => '時間休'],
        ];
        DB::table('sub_report_categories')->insert($param);
    }
}
