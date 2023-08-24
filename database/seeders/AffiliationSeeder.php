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
        $param = [
            ['factory_id' => 1, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], # 1
            ['factory_id' => 2, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], # 2
            ['factory_id' => 2, 'department_id' =>  2, 'group_id' =>  1, 'calender_id' => 1], # 3
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 1], # 4
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  2, 'calender_id' => 1], # 5
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  3, 'calender_id' => 1], # 6
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  1, 'calender_id' => 1], # 7
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  4, 'calender_id' => 1], # 8
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  5, 'calender_id' => 1], # 9
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  1, 'calender_id' => 1], # 10
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  6, 'calender_id' => 1], # 11
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  7, 'calender_id' => 1], # 12
            ['factory_id' => 2, 'department_id' =>  6, 'group_id' =>  8, 'calender_id' => 1], # 13
            ['factory_id' => 2, 'department_id' =>  7, 'group_id' =>  1, 'calender_id' => 1], # 14
            ['factory_id' => 2, 'department_id' =>  8, 'group_id' =>  1, 'calender_id' => 1], # 15
            ['factory_id' => 3, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 2], # 16
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' =>  1, 'calender_id' => 2], # 17
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' =>  9, 'calender_id' => 2], # 18
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' => 10, 'calender_id' => 2], # 19
            ['factory_id' => 3, 'department_id' =>  6, 'group_id' => 11, 'calender_id' => 2], # 20
            ['factory_id' => 3, 'department_id' => 10, 'group_id' =>  1, 'calender_id' => 2], # 21
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 12, 'calender_id' => 2], # 22
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 13, 'calender_id' => 2], # 23
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 14, 'calender_id' => 2], # 24
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 15, 'calender_id' => 2], # 25
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 16, 'calender_id' => 2], # 26
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 17, 'calender_id' => 2], # 27
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 2], # 28
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' => 18, 'calender_id' => 2], # 29
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' =>  2, 'calender_id' => 2], # 30
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' => 19, 'calender_id' => 2], # 31
            ['factory_id' => 4, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 2], # 32
            ['factory_id' => 4, 'department_id' => 11, 'group_id' => 20, 'calender_id' => 2], # 33
            ['factory_id' => 4, 'department_id' => 12, 'group_id' => 21, 'calender_id' => 1], # 34 管理
            ['factory_id' => 4, 'department_id' => 13, 'group_id' => 13, 'calender_id' => 1], # 35 製造支援
            ['factory_id' => 4, 'department_id' => 14, 'group_id' =>  1, 'calender_id' => 2], # 36
            ['factory_id' => 4, 'department_id' => 14, 'group_id' => 22, 'calender_id' => 2], # 37
            ['factory_id' => 4, 'department_id' => 14, 'group_id' => 23, 'calender_id' => 2], # 38
            ['factory_id' => 4, 'department_id' => 15, 'group_id' =>  1, 'calender_id' => 1], # 39 板金
            ['factory_id' => 4, 'department_id' => 15, 'group_id' => 24, 'calender_id' => 1], # 40 板金
            ['factory_id' => 4, 'department_id' => 15, 'group_id' => 25, 'calender_id' => 1], # 41 板金
            ['factory_id' => 4, 'department_id' =>  6, 'group_id' =>  1, 'calender_id' => 1], # 42 品質管理
            ['factory_id' => 5, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 2], # 43
            ['factory_id' => 5, 'department_id' => 16, 'group_id' =>  1, 'calender_id' => 2], # 44
            ['factory_id' => 5, 'department_id' => 17, 'group_id' =>  1, 'calender_id' => 2], # 45
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  1, 'calender_id' => 2], # 46
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  8, 'calender_id' => 2], # 47
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  2, 'calender_id' => 2], # 48
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  3, 'calender_id' => 2], # 49
        ];
        DB::table('affiliations')->insert($param);
    }
}
