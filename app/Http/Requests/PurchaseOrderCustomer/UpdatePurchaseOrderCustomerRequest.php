<?php

namespace App\Http\Requests\PurchaseOrderCustomer;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderCustomerRequest extends FormRequest
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
            "purchase_order_number"  => "required|string",
            // "document"  => "required|string",
            "item.*.delivery_time"  => "required|string",
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
