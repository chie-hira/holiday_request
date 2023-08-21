<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [
            new ReportExport,
            new UserExport,
            new ApprovalExport,
            new RemainingExport,
        ];

        return $sheets;
    }
}
