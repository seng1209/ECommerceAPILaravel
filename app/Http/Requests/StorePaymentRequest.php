<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_date' => (new DateTime())->format('Y-m-d H:i:s'),
            'payment_method_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'status' => 'Completed',
        ];
    }
}
