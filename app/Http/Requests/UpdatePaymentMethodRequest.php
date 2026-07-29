<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'type'           => 'required|string|in:cash,bank_transfer,qris,credit_card,debit_card,ewallet,other',
            'provider'       => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:100',
            'account_name'   => 'nullable|string|max:255',
            'logo_provider'  => 'nullable|image|file|max:2048',
            'image_qris'     => 'nullable|image|file|max:2048',
            'note'           => 'nullable|string',
            'is_active'      => 'nullable',
        ];
    }
}
