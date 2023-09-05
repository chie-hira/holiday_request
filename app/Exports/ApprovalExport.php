<?php

namespace App\Exports;

use App\Models\Approval;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class ApprovalExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Approval::all();
    }

    public function title(): string
    {
        return 'approvals';
    }
}
