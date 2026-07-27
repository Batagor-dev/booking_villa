<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'image'     => 'nullable|image|file|max:2048',
            'link_url'  => 'nullable|string|max:255',
            'status'    => 'nullable',
            'sort'      => 'nullable|integer|min:1',
        ];
    }
}
