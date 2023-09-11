<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcquisitionFormSeeder extends Seeder
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
            ['acquisition_name' => '終日休、連休、半日休、時間休'], #1
            ['acquisition_name' => '終日休、半日休、時間休'], #2
            ['acquisition_name' => '終日休、半日休'], #3
            ['acquisition_name' => '終日休、連休'], #4
            ['acquisition_name' => '終日休'], #5
            ['acquisition_name' => '連休'], #6
            ['acquisition_name' => '時間'], #7
        ];
        DB::table('acquisition_forms')->insert($param);
    }
}
