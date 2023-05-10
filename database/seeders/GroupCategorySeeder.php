<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['group_name' => '全グループ'], # groupがない場合はnull
            ['group_name' => 'プレスG'],
            ['group_name' => '溶接Ｇ'],
            ['group_name' => 'ベンドＧ'],
            ['group_name' => 'ブランクＧ'],
            ['group_name' => '生産管理Ｇ'],
            ['group_name' => '物流・梱包Ｇ'],
            ['group_name' => '検査Ｇ'],
            ['group_name' => '物流G'],
            ['group_name' => '業務G'],
            ['group_name' => '品質管理G'],
            ['group_name' => '保全G'],
            ['group_name' => '製造支援G'],
            ['group_name' => '溶接4G'],
            ['group_name' => '溶接3G'],
            ['group_name' => '溶接2G'],
            ['group_name' => '溶接1G'],
            ['group_name' => 'プレス検査G '],
            ['group_name' => '金型保全Ｇ'],
            ['group_name' => '生技保全Ｇ'],
            ['group_name' => '管理G'],
            ['group_name' => '製造５Ｇ・自動車溶接'],
            ['group_name' => '製造４Ｇ・自動車プレス'],
            ['group_name' => '製造３Ｇ'],
            ['group_name' => '製造1Ｇ'],
        ];
        DB::table('group_categories')->insert($param);
    }
}
