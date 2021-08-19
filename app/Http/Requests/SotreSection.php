<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SotreSection extends FormRequest
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
            'name_section' => 'required|unique:sections',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_section.required' => 'name of section required',
            'name_section.unique' => 'the name allready been taken',
            'description.required' => 'the description is required'
        ];
    }
}
