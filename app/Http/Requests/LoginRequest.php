<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'An email is required',
            'email.email' => 'Incorrect email',
            'password.required' => 'A password is required',
        ];
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json(["data" => $validator->errors(), "success" => false, "message" => "valdiation failed"], 422));
    }
}
