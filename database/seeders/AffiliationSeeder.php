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
            ['factory_id' => 1, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], # 1
            ['factory_id' => 2, 'department_id' =>  2, 'group_id' =>  1, 'calender_id' => 1], # 2
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 1], # 3
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  1, 'calender_id' => 1], # 4
            ['factory_id' => 3, 'department_id' =>  5, 'group_id' =>  1, 'calender_id' => 1], # 
            ['factory_id' => 3, 'department_id' =>  6, 'group_id' =>  1, 'calender_id' => 1], # 
            ['factory_id' => 3, 'department_id' =>  7, 'group_id' =>  1, 'calender_id' => 1], # 
            ['factory_id' => 3, 'department_id' =>  8, 'group_id' =>  1, 'calender_id' => 1], # 
            ['factory_id' => 4, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], # 
            ['factory_id' => 4, 'department_id' =>  9, 'group_id' =>  1, 'calender_id' => 1], # 
        ];
        DB::table('affiliations')->insert($param);
    }
}
