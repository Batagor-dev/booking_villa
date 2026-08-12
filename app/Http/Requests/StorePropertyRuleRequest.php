<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'property_type' => 'required|in:all,Villa,Resort,Boutique Hotel,Apartment,Private House',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'is_active'   => 'nullable',
            'sort_order'  => 'nullable|integer|min:0',
        ];
    }
}
