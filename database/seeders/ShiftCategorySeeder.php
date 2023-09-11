<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftCategorySeeder extends Seeder
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
            [
                'shift_code' => 1,
                'work_time1' => 4,
                'work_time2' => 4,
                'am_pm_switch' => '12:30:00',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'rest1_start_time' => null,
                'rest1_end_time' => null,
                'rest2_start_time' => null,
                'rest2_end_time' => null,
                'rest3_start_time' => null,
                'rest3_end_time' => null,
                'lunch_start_time' => '12:00:00',
                'lunch_end_time' => '13:00:00',
            ],
        ];
        DB::table('shift_categories')->insert($param);
    }
}

