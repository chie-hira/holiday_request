<?php

namespace App\Imports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportImport implements ToModel, WithHeadingRow
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Report([
            'id' => $row['id'],
            'report_date' => $row['report_date'],
            'user_id' => $row['user_id'],
            'report_id' => $row['report_id'],
            'sub_report_id' => $row['sub_report_id'],
            'reason_id' => $row['reason_id'],
            'reason_detail' => $row['reason_detail'],
            'shift_id' => $row['shift_id'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'acquisition_days' => $row['acquisition_days'],
            'acquisition_hours' => $row['acquisition_hours'],
            'acquisition_minutes' => $row['acquisition_minutes'],
            'am_pm' => $row['am_pm'],
            'approval1' => $row['approval1'],
            'approval2' => $row['approval2'],
            'approved' => $row['approved'],
            'cancel' => $row['cancel'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at'],
        ]);
    }
}
