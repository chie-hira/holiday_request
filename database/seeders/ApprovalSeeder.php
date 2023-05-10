<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 1], # 366 総務部長
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 366 一関工場管理者
            ['user_id' => 48, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 366 前沢工場管理者
            ['user_id' => 49, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 201 一関工場閲覧
            ['user_id' => 49, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 201 前沢工場閲覧
            ['user_id' => 50, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 214 一関工場閲覧
            ['user_id' => 50, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 214 前沢工場閲覧
            ['user_id' => 51, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 640 一関工場閲覧
            ['user_id' => 52, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 4], # 499 一関工場閲覧
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 2], # 411 工場長
            ['user_id' => 2, 'factory_id' => 1, 'department_id' => 2, 'group_id' => 1, 'approval_id' => 3], # 618 営業GL
            ['user_id' => 7, 'factory_id' => 1, 'department_id' => 3, 'group_id' => 2, 'approval_id' => 3],
            ['user_id' => 6, 'factory_id' => 1, 'department_id' => 3, 'group_id' => 3, 'approval_id' => 3],
            ['user_id' => 27, 'factory_id' => 1, 'department_id' => 4, 'group_id' => 4, 'approval_id' => 3],
            ['user_id' => 31, 'factory_id' => 1, 'department_id' => 4, 'group_id' => 5, 'approval_id' => 3],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 5, 'group_id' => 6, 'approval_id' => 3],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 5, 'group_id' => 7, 'approval_id' => 3],
            ['user_id' => 47, 'factory_id' => 1, 'department_id' => 6, 'group_id' => 8, 'approval_id' => 3],
            ['user_id' => 56, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 2], # 425 前沢工場長
            ['user_id' => 56, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 425 前沢工場管理者
            ['user_id' => 57, 'factory_id' => 2, 'department_id' => 9, 'group_id' => 9, 'approval_id' => 3],
            ['user_id' => 59, 'factory_id' => 2, 'department_id' => 9, 'group_id' => 10, 'approval_id' => 3],
            ['user_id' => 64, 'factory_id' => 2, 'department_id' => 6, 'group_id' => 11, 'approval_id' => 3],
            ['user_id' => 68, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 12, 'approval_id' => 3],
            ['user_id' => 72, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 13, 'approval_id' => 3],
            ['user_id' => 76, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 14, 'approval_id' => 3],
            ['user_id' => 85, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 3], # 325 溶接4GL
            ['user_id' => 86, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 3], # 450 溶接4GL
            ['user_id' => 97, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 16, 'approval_id' => 3],
            ['user_id' => 108, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 3],
            ['user_id' => 109, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 3],
            ['user_id' => 116, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 18, 'approval_id' => 3],
            ['user_id' => 119, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 2, 'approval_id' => 3],
            ['user_id' => 119, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 19, 'approval_id' => 3],
        ];
        DB::table('approvals')->insert($param);
    }
}
