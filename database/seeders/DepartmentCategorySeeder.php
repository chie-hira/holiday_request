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
            ['department_name' => '無所属'], # 複数の課に所属している場合は無所属
            ['department_name' => '営業課'],
            ['department_name' => 'プレス製造課'],
            ['department_name' => '板金製造課'],
            ['department_name' => '生産管理課'],
            ['department_name' => '品質管理課'],
            ['department_name' => '総務部'],
            ['department_name' => 'システム開発部'],
            ['department_name' => '製造管理課'],
            ['department_name' => '溶接製造課'],
            ['department_name' => '生技保全課'],
            ['department_name' => '管理課'],
            ['department_name' => '製造支援課'],
            ['department_name' => '製造2課（自動車）'],
            ['department_name' => '製造1課（板金）'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
