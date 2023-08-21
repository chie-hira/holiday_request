<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 年度末にリセット
        $param = [
        // TODO:
        // 弔事だけ当日可能
            ['report_name' => '有給休暇', 'max_days' => 40, 'max_times' => null, 'remarks' => null], # 半日有給、時間休も含む
            ['report_name' => 'バースデイ休暇', 'max_days' => 1, 'max_times' => 1, 'remarks' => '誕生日の前後3ヶ月に取得できます'],
            ['report_name' => '特別休暇(慶事)', 'max_days' => 5, 'max_times' => null, 'remarks' => '本人が結婚するとき取得できます'],
            ['report_name' => '特別休暇(弔事・配偶者等)', 'max_days' => 3, 'max_times' => null, 'remarks' => '配偶者、子、同居している父母 の喪に服するとき取得できます'],
            ['report_name' => '特別休暇(弔事・同居の義父母)', 'max_days' => 2, 'max_times' => null, 'remarks' => '同居している配偶者の父母 の喪に服するとき取得できます'],
            ['report_name' => '特別休暇(弔事・別居父母等)', 'max_days' => 1, 'max_times' => null, 'remarks' => '同居していない父母、同居していない配偶者の父母、祖父母、同居している配偶者の祖父母、兄弟姉妹 の喪に服するとき取得できます'],
            ['report_name' => '特別休暇(看護・対象1人)', 'max_days' => 5, 'max_times' => null, 'remarks' => '小学校就学前の子を養育する者が取得できます'], # 時間単位
            ['report_name' => '特別休暇(看護・対象2人以上)', 'max_days' => 10, 'max_times' => null, 'remarks' => '小学校就学前の子を養育する者が取得できます'], # 時間単位
            ['report_name' => '特別休暇(介護・対象1人)', 'max_days' => 5, 'max_times' => null, 'remarks' => '要介護状態の家族を介護する者が取得できます'], # 時間単位
            ['report_name' => '特別休暇(介護・対象2人以上)', 'max_days' => 10, 'max_times' => null, 'remarks' => '要介護状態の家族を介護する者が取得できます'], # 時間単位
            ['report_name' => '特別休暇(短期育休)', 'max_days' => 5, 'max_times' => null, 'remarks' => '1歳に満たない子と同居し扶養する者が取得できます'], # 1日単位
            ['report_name' => '欠勤', 'max_days' => null, 'max_times' => null, 'remarks' => null],
            ['report_name' => '遅刻', 'max_days' => null, 'max_times' => null, 'remarks' => null],
            ['report_name' => '早退', 'max_days' => null, 'max_times' => null, 'remarks' => null],
            ['report_name' => '外出', 'max_days' => null, 'max_times' => null, 'remarks' => null],
            ['report_name' => '介護休業', 'max_days' => 93, 'max_times' => 3, 'remarks' => '要介護状態の家族を介護する者が取得できます'], # 対象家族1人につき
            ['report_name' => '育児休業', 'max_days' => null, 'max_times' => null, 'remarks' => '1歳に満たない子と同居し扶養する者が取得できます'],
            ['report_name' => 'パパ育休', 'max_days' => 28, 'max_times' => null, 'remarks' => '1歳に満たない子と同居し扶養する者が取得できます'],
        ];
        DB::table('report_categories')->insert($param);
    }
}
