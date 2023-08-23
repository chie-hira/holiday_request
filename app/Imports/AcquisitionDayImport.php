<?php

namespace App\Imports;

use App\Models\AcquisitionDay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AcquisitionDayImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    use Importable;

    public function model(array $row)
    {
        // return new AcquisitionDay([
        //     //
        // ]);

        // 既存のレコードをIDで検索して取得
        $existingRecord = AcquisitionDay::where('user_id', $row['user_id'])
            ->where('report_id', $row['report_id'])
            ->first();

        // 既存のレコードが存在すれば更新
        if ($existingRecord) {
            $existingRecord->update([
                'remaining_days' => $row['remaining_days'],
                'acquisition_days' => $row['acquisition_days'],
            ]);
            return $existingRecord;
        }
    }
}
