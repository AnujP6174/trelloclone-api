<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class addTaskFormRequest extends FormRequest
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
            'title' => 'required|max:100',
            'description' => 'required|max:800',
            'emp' => 'required',
            'deadline' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Maximum 100 characters are allowed',
            'description.required' => 'Description is required',
            'description.max' => 'Maximum 800 characters are required',
            'emp.required' => 'Please select one employee',
            'deadline.required' => 'Due date in essential',
        ];
    }
}
