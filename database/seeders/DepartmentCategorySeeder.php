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
        // クライアントに合わせて修正
        $param = [
            ['department_name' => '全グループ'],
            ['department_name' => '製缶製造課 第４工場'],
            ['department_name' => '製缶製造課 西工場'],
            ['department_name' => 'パレット管理課 南工場'],
            ['department_name' => '精密板金課 第３工場'],
            ['department_name' => '精密板金課 第１工場'],
            ['department_name' => '精密板金課 第５工場'],
            ['department_name' => '切断加工課 第２工場'],
            ['department_name' => '事務所'],
            ['department_name' => '製缶製造課 無所属'],
            ['department_name' => '切断加工課 無所属'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
