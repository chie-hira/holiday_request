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
        // 権限は課ごとに設定する。
        $param = [
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 1], # 366 一関工場管理者
            ['user_id' => 48, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 1], # 366 前沢工場管理者
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 7, 'group_id' => 1, 'approval_id' => 2], # 366 一関工場総務部 部長
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 366 一関工場閲覧
            ['user_id' => 49, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 201 一関工場閲覧
            ['user_id' => 49, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 201 前沢工場閲覧
            ['user_id' => 50, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 214 一関工場閲覧
            ['user_id' => 50, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 214 前沢工場閲覧
            ['user_id' => 51, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 640 一関工場閲覧
            ['user_id' => 52, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 499 一関工場閲覧
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 1], # 411 一関工場管理
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 2, 'group_id' => 1, 'approval_id' => 2], # 411 一関工場 自動車一般 工場長
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 4, 'group_id' => 1, 'approval_id' => 2], # 411 一関工場 板金製造 工場長
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 8, 'group_id' => 1, 'approval_id' => 2], # 411 一関工場 システム開発 工場長
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 5], # 411 一関工場 閲覧
            ['user_id' => 6, 'factory_id' => 1, 'department_id' => 3, 'group_id' => 1, 'approval_id' => 3], # 475 一関工場 生産管理課 課長 (テストメンバー75,28)
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 5, 'group_id' => 1, 'approval_id' => 3], # 392 一関工場 プレス製造課 課長
            ['user_id' => 2, 'factory_id' => 1, 'department_id' => 2, 'group_id' => 1, 'approval_id' => 4], # 618 営業GL (テストメンバー506)
            ['user_id' => 7, 'factory_id' => 1, 'department_id' => 3, 'group_id' => 2, 'approval_id' => 4], # 176 プレスGL (テストメンバー75)
            ['user_id' => 27, 'factory_id' => 1, 'department_id' => 4, 'group_id' => 4, 'approval_id' => 4],
            ['user_id' => 31, 'factory_id' => 1, 'department_id' => 4, 'group_id' => 5, 'approval_id' => 4],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 5, 'group_id' => 6, 'approval_id' => 4],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 5, 'group_id' => 7, 'approval_id' => 4],
            ['user_id' => 47, 'factory_id' => 1, 'department_id' => 6, 'group_id' => 8, 'approval_id' => 4],
            ['user_id' => 56, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 1], # 425 前沢工場管理者
            ['user_id' => 56, 'factory_id' => 2, 'department_id' => 1, 'group_id' => 1, 'approval_id' => 2], # 425 前沢工場長
            ['user_id' => 57, 'factory_id' => 2, 'department_id' => 9, 'group_id' => 9, 'approval_id' => 4],
            ['user_id' => 59, 'factory_id' => 2, 'department_id' => 9, 'group_id' => 10, 'approval_id' => 4],
            ['user_id' => 64, 'factory_id' => 2, 'department_id' => 6, 'group_id' => 11, 'approval_id' => 4],
            ['user_id' => 68, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 12, 'approval_id' => 4],
            ['user_id' => 72, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 13, 'approval_id' => 4],
            ['user_id' => 76, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 14, 'approval_id' => 4],
            ['user_id' => 85, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 4], # 325 溶接3GL (テストメンバー407)
            ['user_id' => 86, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 4], # 450 溶接3GL (テストメンバー407)
            ['user_id' => 97, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 16, 'approval_id' => 4],
            ['user_id' => 108, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 4],
            ['user_id' => 109, 'factory_id' => 2, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 4],
            ['user_id' => 116, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 18, 'approval_id' => 4],
            ['user_id' => 119, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 2, 'approval_id' => 4], # 400 プレスG (テストメンバー92)
            ['user_id' => 119, 'factory_id' => 2, 'department_id' => 3, 'group_id' => 19, 'approval_id' => 4], # 400 金型保全G (テストメンバー6)
        ];
        DB::table('approvals')->insert($param);
    }
}
