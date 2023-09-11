<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // このままでOK
        $param = [
            ['date_name' => '祝日等'],
            ['date_name' => '土日営業日'],
        ];
        DB::table('date_categories')->insert($param);
    }
}
