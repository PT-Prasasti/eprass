<?php

namespace App\Http\Requests\DataMaster\Forwarder;

use Illuminate\Foundation\Http\FormRequest;

class AddForwarderRequest extends FormRequest
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
            //
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
            'email' => ':attribute haruslah email',
            'unique' => ':attribute sudah terdaftar',
            'mimes' => 'format :attribute tidak didukung',
        ];
    }
}
