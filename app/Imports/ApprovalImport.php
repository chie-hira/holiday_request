<?php

namespace App\Imports;

use App\Models\Approval;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable; //追加
use Maatwebsite\Excel\Concerns\WithHeadingRow; //追加

class ApprovalImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    
    public function model(array $row)
    {
        return new Approval([
            'user_id' => $row['user_id'],
            'affiliation_id' => $row['affiliation_id'],
            'approval_id' => $row['approval_id'],
        ]);
    }
}
