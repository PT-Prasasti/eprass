<?php

namespace App\Http\Requests\DataMaster\Sales;

use App\Models\User;
use App\Models\Sales;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class AddSalesRequest extends FormRequest
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
            'sales_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Sales::class],
            'phone' => ['required', 'string', 'unique:'.Sales::class],
            'alternate' => ['nullable', 'string'],
            'profile' => ['nullable', 'mimes:jpeg,png,jpg'],
            'username' => ['nullable', 'string', 'unique:'.User::class],
            'password' => ['nullable', Rules\Password::defaults()],
            'sign' => ['nullable', 'mimes:jpeg,png,jpg'],
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
