<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('discount_type') === 'percentage') {
            $this->merge([
                'discount_value' => $this->discount_value_percentage,
            ]);
        } else {
            $this->merge([
                'discount_value' => $this->discount_value_fixed ? str_replace('.', '', $this->discount_value_fixed) : null,
            ]);
        }

        if ($this->has('min_transaction')) {
            $this->merge([
                'min_transaction' => $this->min_transaction ? str_replace('.', '', $this->min_transaction) : null,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'promotion_type' => ['required', 'in:automatic,code'],
            'code' => [
                'required_if:promotion_type,code',
                'nullable',
                'string',
                'unique:promotions,code',
                'max:50'
            ],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->input('discount_type') === 'percentage' && $value > 100) {
                        $fail('Percentage discount value cannot exceed 100%.');
                    }
                }
            ],
            'min_nights' => ['nullable', 'integer', 'min:0'],
            'min_transaction' => ['nullable', 'numeric', 'min:0'],
            'target_type' => ['required', 'in:all,properties,categories,destinations'],
            'property_ids' => ['required_if:target_type,properties', 'array'],
            'property_ids.*' => ['exists:properties,id'],
            'property_types' => ['required_if:target_type,categories', 'array'],
            'property_types.*' => ['string'],
            'destination_ids' => ['required_if:target_type,destinations', 'array'],
            'destination_ids.*' => ['exists:destinations,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['nullable'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'is_featured' => ['nullable'],
            'banner_theme' => ['nullable', 'string', 'in:navy,gold,dark'],
            'features' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
        ];
    }
}
