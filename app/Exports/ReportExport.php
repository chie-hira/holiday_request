<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{

    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return $this->view;
    }
}

// class ReportExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return Report::all();
//     }
// }
