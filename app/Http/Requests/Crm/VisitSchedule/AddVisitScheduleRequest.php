<?php

namespace App\Http\Requests\Crm\VisitSchedule;

use Illuminate\Foundation\Http\FormRequest;

class AddVisitScheduleRequest extends FormRequest
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
            'id' => ['required'],
            'company' => ['required'],
            'visit_by' => ['required'],
            'devision' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'time' => ['nullable'],
            'schedule' => ['nullable'],
            'engineer' => ['nullable'],
            'note' => ['nullable'],
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
            'date' => 'format tanggal salah',
        ];
    }
}
