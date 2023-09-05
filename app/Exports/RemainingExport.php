<?php

namespace App\Exports;

use App\Models\AcquisitionDay;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class RemainingExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AcquisitionDay::all();
    }

    public function title() : string{
		return 'acquisition_days';
	}
}
