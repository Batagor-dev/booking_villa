<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDestinationRequest extends FormRequest
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
        $destination = $this->route('destination');
        $id = is_object($destination) ? $destination->id : null;

        return [
            'name'       => 'required|string|max:255',
            'tags'       => 'nullable|string|max:255',
            'attraction' => 'nullable|string',
            'image'      => 'nullable|image|file|max:2048',
            'status'     => 'nullable',
            'sort'       => [
                'required',
                'integer',
                'min:1',
                Rule::unique('destinations', 'sort')->ignore($id)->whereNull('deleted_at'),
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'sort.unique' => 'This sort order number is already taken. Please specify a unique sort order.',
        ];
    }
}
