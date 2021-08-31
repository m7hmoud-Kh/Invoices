<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Validation\Rules\Unique;

class UpdateSection extends FormRequest
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
            'name_section' => ["unique:sections,name_section," . $this->id],
        ];
    }

    public function messages()
    {
        return [
            'name_section.unique' => 'the name allready been taken',
        ];
    }
}
