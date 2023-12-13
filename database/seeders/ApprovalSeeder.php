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
        // これはインポートする
        $param = [
            ['user_id' => 1	, 'affiliation_id' => 2, 'approval_id' => 2],
            ['user_id' => 2	, 'affiliation_id' => 3, 'approval_id' => 3],
            ['user_id' => 2	, 'affiliation_id' => 1, 'approval_id' => 1],
            ['user_id' => 5	, 'affiliation_id' => 4, 'approval_id' => 3],
            ['user_id' => 8	, 'affiliation_id' => 5, 'approval_id' => 2],
            ['user_id' => 9	, 'affiliation_id' => 6, 'approval_id' => 3],
            ['user_id' => 12, 'affiliation_id' => 7, 'approval_id' => 3],
            ['user_id' => 3	, 'affiliation_id' => 3, 'approval_id' => 4],
            ['user_id' => 3	, 'affiliation_id' => 1, 'approval_id' => 5],
            ['user_id' => 6	, 'affiliation_id' => 4, 'approval_id' => 4],
            ['user_id' => 10, 'affiliation_id' => 6, 'approval_id' => 4],
            ['user_id' => 13, 'affiliation_id' => 7, 'approval_id' => 4],
        ];
        DB::table('approvals')->insert($param);
    }
}
