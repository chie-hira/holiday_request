<?php

namespace App\Imports;

use App\Models\Approval;
use Maatwebsite\Excel\Concerns\ToModel;

class ApprovalImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Approval([
            'user_id' => $row['user_id'],
            'affiliation_id' => $row['affiliation_id'],
            'approval_id' => $row['approval_id'],
        ]);
    }
}
