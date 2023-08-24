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
        $param = [
            ['date' => '20230503', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230504', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230505', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230814', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230815', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230816', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20231103', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240101', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240102', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240103', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240104', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20240223', 'calender_id' => 1, 'date_id' => 1],
            ['date' => '20230819', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20240309', 'calender_id' => 1, 'date_id' => 2],
            ['date' => '20230501', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230502', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230503', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230504', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230505', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230814', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230815', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230816', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230817', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230818', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20240101', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20240102', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20240103', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20240104', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20240105', 'calender_id' => 2, 'date_id' => 1],
            ['date' => '20230429', 'calender_id' => 2, 'date_id' => 2],
            ['date' => '20230812', 'calender_id' => 2, 'date_id' => 2],
            ['date' => '20240120', 'calender_id' => 2, 'date_id' => 2],
            ['date' => '20240210', 'calender_id' => 2, 'date_id' => 2],
            ['date' => '20240309', 'calender_id' => 2, 'date_id' => 2],
        ];
        DB::table('calenders')->insert($param);
    }
}
