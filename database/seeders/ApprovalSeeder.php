<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['user_id' => 48, 'factory_id' => 1, 'department_id' => 10, 'approval_id' => 1],
            ['user_id' => 26, 'factory_id' => 1, 'department_id' => 5, 'approval_id' => 2],
            ['user_id' => 2, 'factory_id' => 1, 'department_id' => 2, 'approval_id' => 3],
            ['user_id' => 7, 'factory_id' => 1, 'department_id' => 3, 'approval_id' => 3],
            ['user_id' => 6, 'factory_id' => 1, 'department_id' => 4, 'approval_id' => 3],
            ['user_id' => 27, 'factory_id' => 1, 'department_id' => 5, 'approval_id' => 3],
            ['user_id' => 31, 'factory_id' => 1, 'department_id' => 6, 'approval_id' => 3],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 7, 'approval_id' => 3],
            ['user_id' => 1, 'factory_id' => 1, 'department_id' => 8, 'approval_id' => 3],
            ['user_id' => 47, 'factory_id' => 1, 'department_id' => 9, 'approval_id' => 3],
        ];
        DB::table('approvals')->insert($param);
    }
}
