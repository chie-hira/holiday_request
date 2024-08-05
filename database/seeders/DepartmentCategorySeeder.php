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
            ['department_name' => '全課'],
            ['department_name' => '第1課'],
            ['department_name' => '第2課'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
