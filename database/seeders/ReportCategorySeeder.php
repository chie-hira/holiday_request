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
            [
                'report_name' => '有給休暇',
                'max_days' => 40,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' => null,
            ], # 半日有給、時間休も含む
            [
                'report_name' => 'バースデイ休暇',
                'max_days' => 1,
                'max_times' => 1,
                'acquisition_id' => 5,
                'apply_on_the_day' => 0,
                'remarks' => null,
            ],
            [
                'report_name' => '特別休暇(慶事)',
                'max_days' => 5,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' => '本人が結婚するとき5日取得できます',
            ],
            [
                'report_name' => '特別休暇(弔事・配偶者等)',
                'max_days' => 3,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '配偶者、子、同居している父母の喪に服するとき3日取得できます',
            ],
            [
                'report_name' => '特別休暇(弔事・同居の義父母)',
                'max_days' => 2,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '同居している配偶者の父母の喪に服するとき2日取得できます',
            ],
            [
                'report_name' => '特別休暇(弔事・別居父母等)',
                'max_days' => 1,
                'max_times' => null,
                'acquisition_id' => 2,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '同居していない父母、同居していない配偶者の父母、祖父母、同居している配偶者の祖父母、兄弟姉妹の喪に服するとき1日取得できます',
            ],
            [
                'report_name' => '特別休暇(看護・対象1人)',
                'max_days' => 5,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' =>
                    '小学校就学前の子を養育する者がの子を看護するとき5日取得できます',
            ], # 時間単位
            [
                'report_name' => '特別休暇(看護・対象2人以上)',
                'max_days' => 10,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' =>
                    '小学校就学前の子を2人以上養育する者が子を看護するとき10日取得できます',
            ], # 時間単位
            [
                'report_name' => '特別休暇(介護・対象1人)',
                'max_days' => 5,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' => '要介護状態の家族を介護するとき5日取得できます',
            ], # 時間単位
            [
                'report_name' => '特別休暇(介護・対象2人以上)',
                'max_days' => 10,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 0,
                'remarks' =>
                    '要介護状態の家族を2人以上介護するとき5日取得できます',
            ], # 時間単位
            [
                'report_name' => '特別休暇(短期育休)',
                'max_days' => 5,
                'max_times' => null,
                'acquisition_id' => 4,
                'apply_on_the_day' => 0,
                'remarks' =>
                    '育児休業を取得しない場合に1歳以下の子1人につき5日取得できます',
            ], # 1日単位
            [
                'report_name' => '欠勤',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 3,
                'apply_on_the_day' => 1,
                'remarks' => null,
            ],
            [
                'report_name' => '遅刻',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 7,
                'apply_on_the_day' => 1,
                'remarks' => '遅刻は10分単位で取得できます',
            ],
            [
                'report_name' => '早退',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 7,
                'apply_on_the_day' => 1,
                'remarks' => '早退は10分単位で取得できます',
            ],
            [
                'report_name' => '外出',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 7,
                'apply_on_the_day' => 1,
                'remarks' => '外出は30分単位で取得できます',
            ],
            [
                'report_name' => '介護休業',
                'max_days' => 93,
                'max_times' => 3,
                'acquisition_id' => 6,
                'apply_on_the_day' => 0,
                'remarks' => null,
            ], # 対象家族1人につき
            [
                'report_name' => '育児休業',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 6,
                'apply_on_the_day' => 0,
                'remarks' => null,
            ],
            [
                'report_name' => 'パパ育休',
                'max_days' => 28,
                'max_times' => null,
                'acquisition_id' => 6,
                'apply_on_the_day' => 0,
                'remarks' => null,
            ],
        ];
        DB::table('report_categories')->insert($param);
    }
}
