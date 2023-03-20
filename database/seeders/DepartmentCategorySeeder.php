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
            ['department_name' => '総務課'],
            ['department_name' => '総務部長'],
            ['department_name' => '工場長'],
            ['department_name' => 'GL'],
        ];
        DB::table('department_categories')->insert($param);
    }
}
