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
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $propertyId = $this->route('property') ? $this->route('property')->id : null;

        return [
            // Main property rules
            'name'                  => 'required|string|max:255',
            'slug'                  => 'nullable|string|max:255|unique:properties,slug,' . $propertyId,
            'code'                  => 'nullable|string|max:50|unique:properties,code,' . $propertyId,
            'type'                  => 'required|string|max:100',
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
            'map_link'              => 'nullable|string',
            'status'                => 'nullable',
            'is_featured'           => 'nullable',


            // Settings rules
            'check_in_time'         => 'nullable|string|max:10',
            'check_out_time'        => 'nullable|string|max:10',
            'cancellation_policy'   => 'nullable|string',
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
