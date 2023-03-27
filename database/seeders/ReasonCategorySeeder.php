<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['reason' => '入院'],
            ['reason' => '通院(本人)'],
            ['reason' => '通院(家族)'],
            ['reason' => '体調不良'],
            ['reason' => '旅行'],
            ['reason' => '農作業'],
            ['reason' => 'その他'],
        ];
        DB::table('reason_categories')->insert($param);
    }
}
