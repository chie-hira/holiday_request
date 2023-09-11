<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonSeeder extends Seeder
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
            ['report_id' =>  1, 'reason_id' =>  1], # 1
            ['report_id' =>  1, 'reason_id' =>  2], # 2
            ['report_id' =>  1, 'reason_id' =>  3], # 3
            ['report_id' =>  1, 'reason_id' =>  4], # 4
            ['report_id' =>  1, 'reason_id' =>  5], # 5
            ['report_id' =>  1, 'reason_id' =>  6], # 6
            ['report_id' =>  1, 'reason_id' =>  7], # 7
            ['report_id' =>  1, 'reason_id' =>  8], # 8
            ['report_id' => 12, 'reason_id' =>  1], # 9
            ['report_id' => 12, 'reason_id' =>  2], # 10
            ['report_id' => 12, 'reason_id' =>  3], # 11
            ['report_id' => 12, 'reason_id' =>  4], # 12
            ['report_id' => 12, 'reason_id' =>  5], # 13
            ['report_id' => 12, 'reason_id' =>  6], # 14
            ['report_id' => 12, 'reason_id' =>  7], # 15
            ['report_id' => 12, 'reason_id' =>  8], # 16
            ['report_id' => 13, 'reason_id' =>  1], # 17
            ['report_id' => 13, 'reason_id' =>  2], # 18
            ['report_id' => 13, 'reason_id' =>  3], # 19
            ['report_id' => 13, 'reason_id' =>  4], # 20
            ['report_id' => 13, 'reason_id' =>  5], # 21
            ['report_id' => 13, 'reason_id' =>  6], # 22
            ['report_id' => 13, 'reason_id' =>  7], # 23
            ['report_id' => 13, 'reason_id' =>  8], # 24
            ['report_id' => 14, 'reason_id' =>  1], # 25
            ['report_id' => 14, 'reason_id' =>  2], 
            ['report_id' => 14, 'reason_id' =>  3], 
            ['report_id' => 14, 'reason_id' =>  4], 
            ['report_id' => 14, 'reason_id' =>  5], 
            ['report_id' => 14, 'reason_id' =>  6], 
            ['report_id' => 14, 'reason_id' =>  7], 
            ['report_id' => 14, 'reason_id' =>  8], 
            ['report_id' => 15, 'reason_id' =>  1], 
            ['report_id' => 15, 'reason_id' =>  2], 
            ['report_id' => 15, 'reason_id' =>  3], 
            ['report_id' => 15, 'reason_id' =>  4], 
            ['report_id' => 15, 'reason_id' =>  5], 
            ['report_id' => 15, 'reason_id' =>  6], 
            ['report_id' => 15, 'reason_id' =>  7], 
            ['report_id' => 15, 'reason_id' =>  8], 
            ['report_id' =>  2, 'reason_id' =>  9], 
            ['report_id' =>  3, 'reason_id' => 10], 
            ['report_id' =>  4, 'reason_id' => 11], 
            ['report_id' =>  5, 'reason_id' => 12], 
            ['report_id' =>  6, 'reason_id' => 13], 
            ['report_id' =>  7, 'reason_id' => 14], 
            ['report_id' =>  7, 'reason_id' => 15], 
            ['report_id' =>  7, 'reason_id' => 16], 
            ['report_id' =>  8, 'reason_id' => 17], 
            ['report_id' =>  8, 'reason_id' => 18], 
            ['report_id' =>  8, 'reason_id' => 19], 
            ['report_id' =>  8, 'reason_id' => 20], 
            ['report_id' =>  9, 'reason_id' => 21], 
            ['report_id' =>  9, 'reason_id' => 22], 
            ['report_id' => 10, 'reason_id' => 23], 
            ['report_id' => 10, 'reason_id' => 24], 
            ['report_id' => 10, 'reason_id' => 25], 
            ['report_id' => 11, 'reason_id' =>  1], 
            ['report_id' => 11, 'reason_id' =>  2], 
            ['report_id' => 11, 'reason_id' =>  4], 
            ['report_id' => 11, 'reason_id' =>  5], 
            ['report_id' => 11, 'reason_id' =>  6], 
        ];
        DB::table('reasons')->insert($param);
    }
}
