<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name' => 'required|unique:products',
            'description' => 'required',
            'section_id' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name of this product required',
            'name.unique' => 'the name allready been taken',
            'description.required' => 'the description is required'
        ];
    }


}
