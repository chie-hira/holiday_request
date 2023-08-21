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
        $param = [
            ['report_id' =>  1, 'reason_id' =>  1], # 1
            ['report_id' =>  1, 'reason_id' =>  2], # 2
            ['report_id' =>  1, 'reason_id' =>  3], # 3
            ['report_id' =>  1, 'reason_id' =>  4], # 4
            ['report_id' =>  1, 'reason_id' =>  5], # 5
            ['report_id' =>  1, 'reason_id' =>  6], # 6
            ['report_id' =>  1, 'reason_id' =>  7], # 7
            ['report_id' =>  1, 'reason_id' =>  9], # 8
            ['report_id' => 12, 'reason_id' =>  1], # 9
            ['report_id' => 12, 'reason_id' =>  2], # 10
            ['report_id' => 12, 'reason_id' =>  3], # 11
            ['report_id' => 12, 'reason_id' =>  4], # 12
            ['report_id' => 12, 'reason_id' =>  5], # 13
            ['report_id' => 12, 'reason_id' =>  6], # 14
            ['report_id' => 12, 'reason_id' =>  7], # 15
            ['report_id' => 12, 'reason_id' =>  9], # 16
            ['report_id' => 12, 'reason_id' =>  1], # 17
            ['report_id' => 13, 'reason_id' =>  2], # 18
            ['report_id' => 13, 'reason_id' =>  3], # 19
            ['report_id' => 13, 'reason_id' =>  4], # 20
            ['report_id' => 13, 'reason_id' =>  5], # 21
            ['report_id' => 13, 'reason_id' =>  6], # 22
            ['report_id' => 13, 'reason_id' =>  7], # 23
            ['report_id' => 13, 'reason_id' =>  9], # 24
            ['report_id' => 14, 'reason_id' =>  2], # 25
            ['report_id' => 14, 'reason_id' =>  3], # 26
            ['report_id' => 14, 'reason_id' =>  4], # 27
            ['report_id' => 14, 'reason_id' =>  5], # 28
            ['report_id' => 14, 'reason_id' =>  6], # 29
            ['report_id' => 14, 'reason_id' =>  7], # 30
            ['report_id' => 14, 'reason_id' =>  9], # 31
            ['report_id' => 15, 'reason_id' =>  2], # 32
            ['report_id' => 15, 'reason_id' =>  3], # 33
            ['report_id' => 15, 'reason_id' =>  4], # 34
            ['report_id' => 15, 'reason_id' =>  5], # 35
            ['report_id' => 15, 'reason_id' =>  6], # 36
            ['report_id' => 15, 'reason_id' =>  7], # 37
            ['report_id' => 15, 'reason_id' =>  9], # 38
            ['report_id' =>  2, 'reason_id' => 10], # 39
            ['report_id' =>  3, 'reason_id' => 11], # 40
            ['report_id' =>  3, 'reason_id' =>  9], # 41
            ['report_id' =>  4, 'reason_id' => 12], # 42
            ['report_id' =>  4, 'reason_id' => 13], # 43
            ['report_id' =>  4, 'reason_id' => 14], # 44
            ['report_id' =>  4, 'reason_id' =>  9], # 45
            ['report_id' =>  5, 'reason_id' => 16], # 46
            ['report_id' =>  6, 'reason_id' => 17], # 47
            ['report_id' =>  6, 'reason_id' => 18], # 48
            ['report_id' =>  6, 'reason_id' => 19], # 49
            ['report_id' =>  6, 'reason_id' => 20], # 50
            ['report_id' =>  6, 'reason_id' =>  9], # 51
            ['report_id' =>  7, 'reason_id' => 21], # 52
            ['report_id' =>  7, 'reason_id' =>  9], # 53
            ['report_id' =>  8, 'reason_id' => 21], # 54
            ['report_id' =>  8, 'reason_id' =>  9], # 55
            ['report_id' =>  9, 'reason_id' => 22], # 56
            ['report_id' =>  9, 'reason_id' => 23], # 57
            ['report_id' =>  9, 'reason_id' => 24], # 58
            ['report_id' =>  9, 'reason_id' => 25], # 59
            ['report_id' =>  9, 'reason_id' => 26], # 60
            ['report_id' =>  9, 'reason_id' => 27], # 61
            ['report_id' =>  9, 'reason_id' => 28], # 62
            ['report_id' =>  9, 'reason_id' =>  9], # 63
            ['report_id' => 10, 'reason_id' => 22], # 64
            ['report_id' => 10, 'reason_id' => 23], # 65
            ['report_id' => 10, 'reason_id' => 24], # 66
            ['report_id' => 10, 'reason_id' => 25], # 67
            ['report_id' => 10, 'reason_id' => 26], # 68
            ['report_id' => 10, 'reason_id' => 27], # 69
            ['report_id' => 10, 'reason_id' => 28], # 70
            ['report_id' => 10, 'reason_id' =>  9], # 71
            ['report_id' => 16, 'reason_id' => 22], # 72
            ['report_id' => 16, 'reason_id' => 23], # 73
            ['report_id' => 16, 'reason_id' => 24], # 74
            ['report_id' => 16, 'reason_id' => 25], # 75
            ['report_id' => 16, 'reason_id' => 26], # 76
            ['report_id' => 16, 'reason_id' => 27], # 77
            ['report_id' => 16, 'reason_id' => 28], # 78
            ['report_id' => 16, 'reason_id' =>  9], # 79
            ['report_id' => 11, 'reason_id' => 29], # 80
            ['report_id' => 11, 'reason_id' =>  9], # 81
            ['report_id' => 17, 'reason_id' => 29], # 82
            ['report_id' => 17, 'reason_id' =>  9], # 83
            ['report_id' => 18, 'reason_id' => 29], # 84
            ['report_id' => 18, 'reason_id' =>  9], # 85
        ];
        DB::table('reasons')->insert($param);
    }
}
