<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyServiceRequest extends FormRequest
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
            'property_id' => 'nullable|exists:properties,id',
            'name'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'price'       => 'required|numeric|min:0',
            'price_type'  => 'required|string|in:per_item,per_person,per_stay,per_hour,fixed',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable|image|file|max:2048',
            'status'      => 'nullable',
            'sort'        => 'nullable|integer|min:1',
        ];
    }
}
