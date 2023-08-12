<?php

namespace App\Exports;

use App\Models\AcquisitionDay;
use Maatwebsite\Excel\Concerns\FromCollection;

class RemainingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AcquisitionDay::all();
    }
}
