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
            ['factory_id' => 2, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], #  2 第1製造部 すべて
            ['factory_id' => 2, 'department_id' =>  2, 'group_id' =>  1, 'calender_id' => 1], #  3 第1製造部 製缶製造課 第４工場
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  1, 'calender_id' => 1], #  4 第1製造部 製缶製造課 西工場
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  1, 'calender_id' => 1], #  5 第1製造部 パレット管理課 南工場
            ['factory_id' => 3, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], #  6 第2製造部 すべて
            ['factory_id' => 3, 'department_id' =>  5, 'group_id' =>  1, 'calender_id' => 1], #  7 第2製造部 精密板金課 第３工場
            ['factory_id' => 3, 'department_id' =>  6, 'group_id' =>  1, 'calender_id' => 1], #  8 第2製造部 精密板金課 第１工場
            ['factory_id' => 3, 'department_id' =>  7, 'group_id' =>  1, 'calender_id' => 1], #  9 第2製造部 精密板金課 第５工場
            ['factory_id' => 3, 'department_id' =>  8, 'group_id' =>  1, 'calender_id' => 1], # 10 第2製造部 切断加工課 第２工場
            ['factory_id' => 4, 'department_id' =>  1, 'group_id' =>  1, 'calender_id' => 1], # 11 総務・経理部 すべて
            ['factory_id' => 4, 'department_id' =>  9, 'group_id' =>  1, 'calender_id' => 1], # 12 総務・経理部 事務所
        ];
        DB::table('affiliations')->insert($param);
    }
}
