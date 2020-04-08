<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'code' => [
                'required',
                'alpha_num',
                'size:6',
                Rule::unique('categories')->ignore($this->category),
            ],
            'name' => 'required|between:3,80',
            'description' => 'required|between:5,255',
            'iva' => 'required|numeric',
        ];
    }
}
