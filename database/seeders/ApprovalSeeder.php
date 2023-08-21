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
            ['user_id' => 37, 'affiliation_id' =>  1, 'approval_id' =>  1], # 366 全工場 管理者
            ['user_id' => 37, 'affiliation_id' => 14, 'approval_id' =>  2], # 366 一関工場総務部 部長
            ['user_id' => 37, 'affiliation_id' =>  1, 'approval_id' =>  4], # 366 全工場 閲覧
            ['user_id' => 22, 'affiliation_id' =>  1, 'approval_id' =>  4], # 201 全工場 閲覧
            ['user_id' => 24, 'affiliation_id' =>  1, 'approval_id' =>  4], # 214 全工場 閲覧
            ['user_id' => 95, 'affiliation_id' =>  2, 'approval_id' =>  4], # 640 一関工場 閲覧
            ['user_id' => 62, 'affiliation_id' =>  2, 'approval_id' =>  4], # 499 一関工場 閲覧
            ['user_id' => 50, 'affiliation_id' =>  2, 'approval_id' =>  1], # 411 一関工場 管理者
            ['user_id' => 50, 'affiliation_id' =>  3, 'approval_id' =>  2], # 411 一関工場 自動車一般 工場長
            ['user_id' => 50, 'affiliation_id' =>  4, 'approval_id' =>  2], # 411 一関工場 プレス製造 工場長
            ['user_id' => 50, 'affiliation_id' =>  7, 'approval_id' =>  2], # 411 一関工場 板金製造 工場長
            ['user_id' => 50, 'affiliation_id' => 15, 'approval_id' =>  2], # 411 一関工場 システム開発 工場長
            ['user_id' => 50, 'affiliation_id' =>  2, 'approval_id' =>  4], # 411 一関工場 閲覧
            ['user_id' => 58, 'affiliation_id' =>  6, 'approval_id' =>  3], # 475 一関工場 生産管理課 課長 (テストメンバー75,28)
            ['user_id' => 42, 'affiliation_id' => 10, 'approval_id' =>  3], # 392 一関工場 プレス製造課 課長
            ['user_id' => 88, 'affiliation_id' =>  3, 'approval_id' =>  3], # 618 営業 GL (テストメンバー506)
            ['user_id' => 17, 'affiliation_id' =>  5, 'approval_id' =>  3], # 176 プレス GL (テストメンバー75)
            ['user_id' => 31, 'affiliation_id' =>  8, 'approval_id' =>  3], # 302 ベンドＧGL
            ['user_id' =>  7, 'affiliation_id' =>  9, 'approval_id' =>  3], # 42 ブランクＧGL
            ['user_id' =>  8, 'affiliation_id' => 13, 'approval_id' =>  3], # 51 検査ＧGL
            ['user_id' => 54, 'affiliation_id' => 16, 'approval_id' =>  1], # 425 前沢工場 管理者
            ['user_id' => 54, 'affiliation_id' => 16, 'approval_id' =>  2], # 425 前沢工場長
            // ['user_id' => 45, 'factory_id' => 3, 'department_id' => 9, 'group_id' => 9, 'approval_id' => 3], # 398 物流G
            // ['user_id' => 40, 'factory_id' => 3, 'department_id' => 9, 'group_id' => 10, 'approval_id' => 3], # 384 業務G
            // ['user_id' => 35, 'factory_id' => 3, 'department_id' => 6, 'group_id' => 11, 'approval_id' => 3], # 339 品質管理G
            // ['user_id' => 47, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 12, 'approval_id' => 3], # 401 保全G
            // ['user_id' => 19, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 13, 'approval_id' => 3], # 189 製造支援G
            // ['user_id' => 84, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 14, 'approval_id' => 3], # 611 溶接4G
            // ['user_id' => 32, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 3], # 325 溶接3GL (テストメンバー407)
            // ['user_id' => 56, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 15, 'approval_id' => 3], # 450 溶接3GL (テストメンバー407)
            // ['user_id' => 74, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 16, 'approval_id' => 3], # 569 溶接2G
            // ['user_id' => 43, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 3], # 395 溶接1G
            // ['user_id' => 107, 'factory_id' => 3, 'department_id' => 10, 'group_id' => 17, 'approval_id' => 3], # 688 溶接1G
            // ['user_id' => 25, 'factory_id' => 3, 'department_id' => 3, 'group_id' => 18, 'approval_id' => 3], # 246 プレス検査G 
            // ['user_id' => 46, 'factory_id' => 3, 'department_id' => 3, 'group_id' => 2, 'approval_id' => 3], # 400 プレスG (テストメンバー92)
            // ['user_id' => 46, 'factory_id' => 3, 'department_id' => 3, 'group_id' => 19, 'approval_id' => 3], # 400 金型保全G (テストメンバー6)
        ];
        DB::table('approvals')->insert($param);
    }
}
