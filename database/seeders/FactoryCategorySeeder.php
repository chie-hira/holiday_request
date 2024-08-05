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
            ['factory_name' => '全部門'],
            ['factory_name' => '部門1'],
            ['factory_name' => '部門2'],
        ];
        DB::table('factory_categories')->insert($param);
    }
}
