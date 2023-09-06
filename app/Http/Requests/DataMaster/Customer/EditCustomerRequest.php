<?php

namespace App\Http\Requests\DataMaster\Customer;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class EditCustomerRequest extends FormRequest
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
        // Fetch the original username from the database based on the 'uuid'
        $originalUsername = Customer::where('uuid', $this->input('uuid'))->first()->username ?? null;

        return [
            'uuid' => ['required'],
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string'],
            'alternate' => ['nullable', 'string'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_phone' => ['required'],
            'company_fax' => ['nullable'],
            'profile' => ['nullable', 'mimes:jpeg,png,jpg'],
            'username' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($originalUsername) {
                    if($originalUsername !== $value) {
                        // Run unique validation for the new username
                        if (User::where('username', $value)->exists()) {
                            $fail($attribute.' sudah terdaftar.');
                        }
                    }
                }
            ],
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
            'mimes' => 'format :attribute tidak didukung',
        ];
    }
}
