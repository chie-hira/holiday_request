<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalenderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['calender_name' => 'カレンダー1'], # 一関本社
            ['calender_name' => 'カレンダー2'], # 平泉,NSE
        ];
        DB::table('calender_categories')->insert($param);
    }
}
