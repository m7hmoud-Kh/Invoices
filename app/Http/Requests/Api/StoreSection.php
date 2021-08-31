<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreSection extends FormRequest
{


    public $validator = null;


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

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
