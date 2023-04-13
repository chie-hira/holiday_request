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
        $param = [
            ['reason' => '体調不良'],
            ['reason' => '通院(本人)'],
            ['reason' => '通院(家族)'],
            ['reason' => '入院(本人)'],
            ['reason' => '入院(家族)'],
            ['reason' => '旅行'],
            ['reason' => '農作業'],
            ['reason' => 'その他'],
            ['reason' => '誕生日'],
            ['reason' => '結婚'],
            ['reason' => '死亡(配偶者)'],
            ['reason' => '死亡(子)'],
            ['reason' => '死亡(同居父母)'],
            ['reason' => '死亡(別居父母)'],
            ['reason' => '死亡(配偶者の同居父母)'],
            ['reason' => '死亡(配偶者の別居父母)'],
            ['reason' => '死亡(祖父母)'],
            ['reason' => '死亡(配偶者の同居祖父母)'],
            ['reason' => '死亡(兄弟姉妹)'],
            ['reason' => '看護(子)'],
            ['reason' => '介護(配偶者)'],
            ['reason' => '介護(父母)'],
            ['reason' => '介護(子)'],
            ['reason' => '介護(配偶者の父母)'],
            ['reason' => '介護(祖父母)'],
            ['reason' => '介護(兄弟姉妹)'],
            ['reason' => '介護(孫)'],
            ['reason' => '育児'],
        ];
        DB::table('reason_categories')->insert($param);
    }
}
