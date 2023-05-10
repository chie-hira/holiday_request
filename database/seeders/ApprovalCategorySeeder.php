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
            # 承諾権限は閲覧含む
            ['approval_name' => '会社承諾'], # 総務部長承諾
            ['approval_name' => '工場承諾'], # 工場長承諾
            ['approval_name' => 'グループ承諾'], # GL承諾
            ['approval_name' => '閲覧'],
            ['approval_name' => '管理者'], # 各種設定権限
        ];
        DB::table('approval_categories')->insert($param);
    }
}
