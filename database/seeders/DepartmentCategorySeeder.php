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
            ['department_name' => '総務課'],
            ['department_name' => '管理G'],
            ['department_name' => '製造支援G'],
            ['department_name' => '製造1'],
            ['department_name' => '製造2'],
            ['department_name' => '製造3'],
            ['department_name' => '製造4'],
            ['department_name' => '製造5'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
