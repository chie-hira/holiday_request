<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalCategorySeeder extends Seeder
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
            # 承認権限は閲覧含む
            ['approval_name' => '管理者'], # 各種設定権限
            ['approval_name' => '部長承認'], # 部長承認
            ['approval_name' => '課長承認'], # 課長承認
            ['approval_name' => '閲覧'],
            ['approval_name' => '事務責任者'], # 管理者&閲覧&毎日メール
        ];
        DB::table('approval_categories')->insert($param);
    }
}
