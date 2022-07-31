<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class NewPasswordRequest extends FormRequest
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
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
            // 'cpassword' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please Enter Email',
            'email.email' => 'Email should contain @,should have alphabets after .',
            'password.required' => 'Please Enter Password',
            'password.regex' => 'Password must contain lower,upper,numbers,special characters and should be 8 characters long',
            // 'cpassword.required' => 'Please Enter Password Again',
            // 'cpassword.same' => 'Confirm password must be same as Password'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // $this->setMeta('message', $validator->messages()->first());
        // $this->setMeta('status', 'fail');
        $response = new JsonResponse($validator->messages()->first());
        throw (new ValidationException($validator, $response))->status(404);
    }
}
