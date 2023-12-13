<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliationSeeder extends Seeder
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
            ['factory_id' => 1, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], #  1 すべて
            ['factory_id' => 2, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], #  2 部門1
            ['factory_id' => 2, 'department_id' =>  2, 'group_id' =>  1, 'calender_id' => 1], #  3 部門1 第1課
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 1], #  4 部門1 第2課
            ['factory_id' => 3, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], #  5 部門2
            ['factory_id' => 3, 'department_id' =>  2, 'group_id' =>  1, 'calender_id' => 1], #  6 部門2 第1課
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 1], #  7 部門2 第2課
        ];
        DB::table('affiliations')->insert($param);
    }
}
