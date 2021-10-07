<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTask extends FormRequest
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
        $priority = [
            'low', 'medium', 'high'
        ];
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'title'   => 'nullable|string|max:50|unique:tasks,user_id'.$this->user_id,
            'description'  => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'priority' => ['nullable', 'string', Rule::in($priority)],
            'start_date'  => 'nullable|date',
            'end_date'  => 'nullable|date',
            'access' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'access.boolean' => 'Invalid data',
            'priority.in' => 'Please specify a valid priority type',
            'status.in' => 'Please specify a valid status type'
        ];
    }
}
