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
        $param = [
            # 承認権限は閲覧含む
            ['approval_name' => '管理者'], # 各種設定権限
            ['approval_name' => '上長承認'], # 工場長承認
            ['approval_name' => 'GL承認'], # GL承認
            ['approval_name' => '閲覧'],
        ];
        DB::table('approval_categories')->insert($param);
    }
}
