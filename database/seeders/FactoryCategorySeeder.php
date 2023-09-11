<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactoryCategorySeeder extends Seeder
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
            ['factory_name' => '全部'],
            ['factory_name' => '第1製造部'],
            ['factory_name' => '第2製造部'],
            ['factory_name' => '総務・経理部'],
        ];
        DB::table('factory_categories')->insert($param);
    }
}
