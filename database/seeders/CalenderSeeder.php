<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // クライアントに合わせて修正
        $param = [
            ['date' => '20230503', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230504', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230505', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230717', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230811', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230814', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230815', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230816', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230918', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20231009', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20231103', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20231123', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20231229', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240101', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240102', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240103', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240104', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240108', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240212', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240223', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240320', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230401', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230422', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230513', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230610', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230701', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230722', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230805', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230819', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230902', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230916', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20231014', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20231111', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20231125', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20231216', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240106', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240113', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240203', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240217', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240223', 'calender_id' => 1, 'date_id' => 2],
        ];
        DB::table('calenders')->insert($param);
    }
}
