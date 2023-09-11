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
        // クライアントに合わせて修正
        $param = [
            [
                'report_name' => '有給休暇',
                'max_days' => 40,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' => null,
            ],
            [
                'report_name' => 'バースデイ休暇',
                'max_days' => 1,
                'max_times' => 1,
                'acquisition_id' => 5,
                'apply_on_the_day' => 1,
                'remarks' => null,
            ],
            [
                'report_name' => '慶事休暇(結婚・本人)',
                'max_days' => 7,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' => '本人が結婚するとき7日取得できます',
            ],
            [
                'report_name' => '慶事休暇(結婚・子)',
                'max_days' => 3,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' => '子が結婚するとき3日取得できます',
            ],
            [
                'report_name' => '慶事休暇(結婚・兄弟姉妹)',
                'max_days' => 1,
                'max_times' => null,
                'acquisition_id' => 2,
                'apply_on_the_day' => 1,
                'remarks' => '兄弟姉妹が結婚するとき1日取得できます',
            ],
            [
                'report_name' => '慶事休暇(配偶者の出産)',
                'max_days' => 3,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' => '配偶者が出産するとき3日取得できます',
            ],
            [
                'report_name' => '弔事休暇(死亡・父母、配偶者、子)',
                'max_days' => 5,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '父母、配偶者、子の喪に服するとき5日取得できます',
            ], 
            [
                'report_name' => '弔事休暇(死亡・祖父母、配偶者の父母、兄弟、孫)',
                'max_days' => 3,
                'max_times' => null,
                'acquisition_id' => 1,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '祖父母、配偶者の父母、兄弟、孫の喪に服するとき3日取得できます',
            ], 
            [
                'report_name' => '弔事休暇(死亡・伯叔父母、甥、姪)',
                'max_days' => 1,
                'max_times' => null,
                'acquisition_id' => 2,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '伯叔父母、甥、姪の喪に服するとき1日取得できます',
            ], 
            [
                'report_name' => '弔事休暇(法事)',
                'max_days' => 1,
                'max_times' => null,
                'acquisition_id' => 2,
                'apply_on_the_day' => 1,
                'remarks' =>
                    '法事に出席するとき1日取得できます',
            ], 
            [
                'report_name' => '特別休暇(労災等)',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 4,
                'apply_on_the_day' => 0,
                'remarks' => null,
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
                'remarks' => '遅刻は15分単位で取得できます',
            ],
            [
                'report_name' => '早退',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 7,
                'apply_on_the_day' => 1,
                'remarks' => '早退は15分単位で取得できます',
            ],
            [
                'report_name' => '外出',
                'max_days' => null,
                'max_times' => null,
                'acquisition_id' => 7,
                'apply_on_the_day' => 1,
                'remarks' => '外出は15分単位で取得できます',
            ],
        ];
        DB::table('report_categories')->insert($param);
    }
}
