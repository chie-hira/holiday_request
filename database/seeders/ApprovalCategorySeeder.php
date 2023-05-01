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
            ['approval_name' => '総務部長'],
            ['approval_name' => '工場長'],
            ['approval_name' => 'GL'],
            ['approval_name' => '閲覧'],
        ];
        DB::table('approval_categories')->insert($param);
    }
}
