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
        $param = [
            ['factory_name' => '一関'],
            ['factory_name' => '前沢'],
            ['factory_name' => '平泉'],
            ['factory_name' => '藤沢'],
        ];
        DB::table('factory_categories')->insert($param);
    }
}
