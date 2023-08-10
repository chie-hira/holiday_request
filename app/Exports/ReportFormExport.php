<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportFormExport implements FromView
{
    protected $view;
    
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
