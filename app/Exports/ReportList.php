<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportList implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // ヘッダー行の内容を返す
        return [
            '所属',
            '社員番号',
            '名前',
            '休暇種類',
            '休暇日・始',
            '休暇日・終',
            '休暇時間・始',
            '休暇時間・終',
            '半休',
            '取得日数',
            'シフトコード',
            '届出日',
            '理由',
            '詳細・備考',
        ];
    }
}
