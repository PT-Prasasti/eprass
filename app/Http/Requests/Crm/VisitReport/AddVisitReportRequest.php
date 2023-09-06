<?php

namespace App\Http\Requests\Crm\VisitReport;

use Illuminate\Foundation\Http\FormRequest;

class AddVisitReportRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'visit' => ['required'],
            'status' => ['required'],
            'next_date_visit' => ['nullable'],
            'next_time_visit' => ['nullable'],
            'engineer' => ['nullable'],
            'note_staff' => ['nullable'],
            'note' => ['nullable'],
            'planing' => ['nullable'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi',
        ];
    }
}
