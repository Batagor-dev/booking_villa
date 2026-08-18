<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
        if ($this->has('price')) {
            $this->merge([
                'price' => str_replace('.', '', $this->price),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $propertyId = $this->route('property') ? $this->route('property')->id : null;

        return [
            // Main property rules
            'name'                  => 'required|string|max:255',
            'destination_id'        => 'nullable|exists:destinations,id',
            'slug'                  => 'nullable|string|max:255|unique:properties,slug,' . $propertyId,
            'code'                  => 'nullable|string|max:50',
            'type'                  => 'required|in:Villa,Resort,Boutique Hotel,Apartment,Private House',
            'price'                 => 'required|numeric|min:0',
            'bedrooms'              => 'required|integer|min:1',
            'capacity'              => 'required|integer|min:1',
            'rating'                => 'nullable|numeric|between:0,5',
            'description'           => 'nullable|string',
            'address'               => 'nullable|string',
            'city'                  => 'nullable|string|max:100',
            'province'              => 'nullable|string|max:100',
            'postal_code'           => 'nullable|string|max:20',
            'main_image'            => 'nullable|image|file|max:3072',
            'map_link'              => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !str_contains(trim($value), '<iframe')) {
                        $fail('Input Google Maps harus berupa kode HTML tag <iframe>...</iframe> (Share -> Embed a map). Link biasa tidak dapat digunakan.');
                    }
                },
            ],
            'status'                => 'nullable',
            'is_featured'           => 'nullable',

            // Settings rules
            'phone'                 => 'nullable|string|max:50',
            'email'                 => 'nullable|email|max:255',
            'currency'              => 'nullable|string|max:10',
            'latitude'              => 'nullable|numeric|between:-90,90',
            'longitude'             => 'nullable|numeric|between:-180,180',

            // Facilities rules
            'facilities'            => 'nullable|array',
            'facilities.*'          => 'exists:facilities,id',

            // Gallery images rules
            'gallery_images'        => 'nullable|array',
            'gallery_images.*'      => 'image|file|max:3072',
            'delete_galleries'      => 'nullable|array',
            'delete_galleries.*'    => 'exists:property_galleries,id',
        ];
    }
}
