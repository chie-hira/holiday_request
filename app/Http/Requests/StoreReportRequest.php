<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'report_date' => 'required|date',
            'user_id' => 'required|integer',
            'report_id' => 'required|integer',
            'sub_report_id' => 'required|integer',
            'reason_id' => 'required|integer',
            'reason_detail' => 'max:50', # ここにstringはNG。stringはnullを許容しないのでrequiredをかねる。
            'start_date' => 'required|date|after_or_equal:report_date',
            'end_date' => 'nullable|date|after_or_equal:start_date|sameMonth:start_date', # nullableがないとafter_or_equalでrequired
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'get_days' => 'required',
            'am_pm' => 'nullable|integer',
            'remarks' => 'max:50',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'get_days.required' =>
                '日付を入力して、日付算出ボタンを押してください。',
        ];
    }
}
