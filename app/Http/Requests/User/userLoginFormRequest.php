<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class userLoginFormRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please Enter Email',
            'email.email' => 'Email should contain numbers,@, and alphabets after .',
            'password.required' => 'Please Enter Password',
        ];
    }
}
