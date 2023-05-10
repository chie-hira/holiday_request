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
            ['factory_name' => '一関本社'],
            ['factory_name' => '前沢工場'],
            ['factory_name' => '平泉工場'],
            ['factory_name' => '藤沢工場'],
        ];
        DB::table('factory_categories')->insert($param);
    }
}
