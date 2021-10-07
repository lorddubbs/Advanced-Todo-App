<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            'name'   => 'required|string|max:50|unique:categories,name,'.$this->user_id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Add a name to this category',
            'name.unique' => 'This category already exists'
        ];
    }
}
