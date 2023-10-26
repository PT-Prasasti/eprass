<?php

namespace App\Http\Requests\Transaction\Quotation;

use Illuminate\Foundation\Http\FormRequest;

class AddQuotationRequest extends FormRequest
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
            "sales_order"  => "required|exists:App\Models\SalesOrder,uuid",
            "due_date"  => "required|date",
            "payment_term"  => "required|string",
            "delivery_term"  => "required|string",
            "vat"  => "required|string",
            "validity"  => "required|string",
            "attachment"  => "required|string",
            "item.*.cost"  => "required|string",
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
            'regex:/^\d+(\.\d{1,2})?$/' => 'format salah',
        ];
    }
}
