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
        // クライアントに合わせて修正
        $param = [
            ['reason' => 'その他'], #1
            ['reason' => '体調不良'], #2
            ['reason' => '私用'], #3
            ['reason' => '怪我'], #4
            ['reason' => '通院'], #5
            ['reason' => '事故(交通渋滞含み)'], #6
            ['reason' => '農作業'], #7
            ['reason' => '子供の行事'], #8
            ['reason' => '誕生日'], #9
            ['reason' => '結婚(本人)'], #10
            ['reason' => '結婚(子)'], #11
            ['reason' => '結婚(兄弟姉妹)'], #12
            ['reason' => '出産(配偶者)'], #13
            ['reason' => '死亡(父母)'], #14
            ['reason' => '死亡(配偶者)'], #15
            ['reason' => '死亡(子)'], #16
            ['reason' => '死亡(祖父母)'], #17
            ['reason' => '死亡(配偶者の父母)'], #18
            ['reason' => '死亡(兄弟姉妹)'], #19
            ['reason' => '死亡(孫)'], #20
            ['reason' => '死亡(伯叔父母)'], #21
            ['reason' => '死亡(甥、姪)'], #22
            ['reason' => '法事(直系尊属)'], #23
            ['reason' => '法事(配偶者)'], #24
            ['reason' => '法事(子の忌日)'], #25
        ];
        DB::table('reason_categories')->insert($param);
    }
}
