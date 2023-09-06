<?php

namespace App\Http\Requests\DataMaster\Customer;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends FormRequest
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
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Customer::class],
            'phone' => ['required', 'string', 'unique:'.Customer::class],
            'alternate' => ['nullable', 'string', 'unique:'.Customer::class],
            'company_name' => ['required', 'string', 'max:255'],
            'company_phone' => ['required'],
            'company_fax' => ['nullable'],
            'profile' => ['nullable', 'mimes:jpeg,png,jpg'],
            'username' => ['nullable', 'string', 'unique:'.User::class],
            'password' => ['nullable', Rules\Password::defaults()],
            'address' => ['required', 'string'],
            'note' => ['nullable']
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
