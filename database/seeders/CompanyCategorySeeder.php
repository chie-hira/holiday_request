<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['company_name' => '一関'],
            ['company_name' => '前沢'],
            ['company_name' => '平泉'],
            ['company_name' => '藤沢'],
        ];
        DB::table('company_categories')->insert($param);
    }
}
