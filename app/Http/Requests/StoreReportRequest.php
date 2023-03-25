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
            'reason_id' => 'required|integer',
            'get_days' => 'required|min:0',
        ];
    }
}
