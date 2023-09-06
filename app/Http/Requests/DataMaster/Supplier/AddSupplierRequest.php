<?php

namespace App\Http\Requests\DataMaster\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class AddSupplierRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:'.Supplier::class],
            'company_phone' => ['required', 'string', 'unique:'.Supplier::class],
            'item_spesialization' => ['nullable', 'string'],
            'sales_representative' => ['required', 'string'],
            'contact_number' => ['nullable', 'string'],
            'sales_email' => ['nullable', 'string', 'email'],
            'location' => ['required'],
            'bank_name' => ['nullable', 'string'],
            'bank_number' => ['nullable', 'string'],
            'bank_account' => ['nullable', 'string'],
            'bank_swift' => ['nullable'],
            'address' => ['nullable'],
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
            'unique' => ':attribute sudah terdaftar'
        ];
    }
}
