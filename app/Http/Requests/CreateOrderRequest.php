<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|integer',
            'order_detail.*.product_id' => 'required|integer',
            'order_detail.*.quantity' => 'required|integer',
            'order_detail.*.price' => ['required', 'numeric', 'min:0.00', 'max:99999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
