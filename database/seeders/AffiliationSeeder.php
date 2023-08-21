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
            ['factory_id' => 1, 'department_id' =>  1, 'group_id' =>  1], # 1
            ['factory_id' => 2, 'department_id' =>  1, 'group_id' =>  1], # 2
            ['factory_id' => 2, 'department_id' =>  2, 'group_id' =>  1], # 3
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  1], # 4
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  2], # 5
            ['factory_id' => 2, 'department_id' =>  3, 'group_id' =>  3], # 6
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  1], # 7
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  4], # 8
            ['factory_id' => 2, 'department_id' =>  4, 'group_id' =>  5], # 9
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  1], # 10
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  6], # 11
            ['factory_id' => 2, 'department_id' =>  5, 'group_id' =>  7], # 12
            ['factory_id' => 2, 'department_id' =>  6, 'group_id' =>  8], # 13
            ['factory_id' => 2, 'department_id' =>  7, 'group_id' =>  1], # 14
            ['factory_id' => 2, 'department_id' =>  8, 'group_id' =>  1], # 15
            ['factory_id' => 3, 'department_id' =>  1, 'group_id' =>  1], # 16
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' =>  1], # 17
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' =>  9], # 18
            ['factory_id' => 3, 'department_id' =>  9, 'group_id' => 10], # 19
            ['factory_id' => 3, 'department_id' =>  6, 'group_id' => 11], # 20
            ['factory_id' => 3, 'department_id' => 10, 'group_id' =>  1], # 21
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 12], # 22
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 13], # 23
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 14], # 24
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 15], # 25
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 16], # 26
            ['factory_id' => 3, 'department_id' => 10, 'group_id' => 17], # 27
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' =>  1], # 28
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' => 18], # 29
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' =>  2], # 30
            ['factory_id' => 3, 'department_id' =>  3, 'group_id' => 19], # 31
            ['factory_id' => 4, 'department_id' =>  1, 'group_id' =>  1], # 32
            ['factory_id' => 4, 'department_id' => 11, 'group_id' => 20], # 33
            ['factory_id' => 4, 'department_id' => 12, 'group_id' => 21], # 34
            ['factory_id' => 4, 'department_id' => 13, 'group_id' => 13], # 35
            ['factory_id' => 4, 'department_id' => 14, 'group_id' =>  1], # 36
            ['factory_id' => 4, 'department_id' => 14, 'group_id' => 22], # 37
            ['factory_id' => 4, 'department_id' => 14, 'group_id' => 23], # 38
            ['factory_id' => 4, 'department_id' => 15, 'group_id' =>  1], # 39
            ['factory_id' => 4, 'department_id' => 15, 'group_id' => 24], # 40
            ['factory_id' => 4, 'department_id' => 15, 'group_id' => 25], # 41
            ['factory_id' => 4, 'department_id' =>  6, 'group_id' =>  1], # 42
            ['factory_id' => 5, 'department_id' =>  1, 'group_id' =>  1], # 43
            ['factory_id' => 5, 'department_id' => 16, 'group_id' =>  1], # 44
            ['factory_id' => 5, 'department_id' => 17, 'group_id' =>  1], # 45
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  1], # 46
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  8], # 47
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  2], # 48
            ['factory_id' => 5, 'department_id' => 18, 'group_id' =>  3], # 49
        ];
        DB::table('affiliations')->insert($param);
    }
}
