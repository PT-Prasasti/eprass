<?php

namespace App\Http\Requests\Transaction\Price;

use Illuminate\Foundation\Http\FormRequest;

class AddPriceRequest extends FormRequest
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
            "price_list.*.delivery_time"  => "required|string",
            "price_list.*.currency"  => "required|in:IDR,USD",
            "price_list.*.shipping_fee"  => "required|regex:/^\d+(\.\d{1,2})?$/",
            "price_list.*.profit"  => "required|regex:/^\d+(\.\d{1,2})?$/",
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
            'in:IDR,USD' => 'Hanya menerima mata uang IDR atau USD',
            'regex:/^\d+(\.\d{1,2})?$/' => 'format salah',
        ];
    }
}
