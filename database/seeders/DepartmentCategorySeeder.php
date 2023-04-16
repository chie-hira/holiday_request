<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['department_name' => '無所属'],
            ['department_name' => '営業課(自動車・一般）'],
            ['department_name' => 'プレス製造課(プレスG)'],
            ['department_name' => 'プレス製造課(溶接Ｇ)'],
            ['department_name' => '板金製造課(ベンドＧ)'],
            ['department_name' => '板金製造課(ブランクＧ)'],
            ['department_name' => '生産管理課(生産管理Ｇ)'],
            ['department_name' => '生産管理課(物流・梱包Ｇ)'],
            ['department_name' => '品質管理課(検査Ｇ)'],
            ['department_name' => '総務部'],
            ['department_name' => 'システム開発部'],
            ['department_name' => '製造管理課(物流G)'],
            ['department_name' => '製造管理課(業務G)'],
            ['department_name' => '品質管理課(品質管理G)'],
            ['department_name' => '溶接製造課(保全G)'],
            ['department_name' => '溶接製造課(製造支援G)'],
            ['department_name' => '溶接製造課(溶接4G)'],
            ['department_name' => '溶接製造課(溶接3G)'],
            ['department_name' => '溶接製造課(溶接2G)'],
            ['department_name' => '溶接製造課(溶接1G)'],
            ['department_name' => 'プレス製造課(プレス検査G )'],
            ['department_name' => 'プレス製造課(プレスG )'],
            ['department_name' => 'プレス製造課(金型保全Ｇ)'],
            ['department_name' => '生技保全課(生技保全Ｇ)'],
            ['department_name' => '管理課(管理G)'],
            ['department_name' => '製造支援課(製造支援Ｇ)'],
            ['department_name' => '製造2課（自動車）(製造５Ｇ・自動車溶接）'],
            ['department_name' => '製造2課（自動車）(製造４Ｇ・自動車プレス）'],
            ['department_name' => '製造1課（板金）(製造３Ｇ)'],
            ['department_name' => '製造1課（板金）(製造1Ｇ)'],
            ['department_name' => '品質管理課'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
