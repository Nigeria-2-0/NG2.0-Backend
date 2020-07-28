<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRegister extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'gender' => 'nullable|string',
            'phone' => 'required|string|min:10',
            'lga' => 'required|string',
            'state' => 'required|string',
            'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'email.required' => 'An email is required',
            'email.email' => 'Incorrect email',
            'phone.required' => 'A phone number is required',
            'lga.required' => 'Local government area is required',
            'state.required' => 'A state is required',
            'password.required' => 'A password is required',
        ];
    }

    protected function failedValidation($validator) {
        throw new HttpResponseException(response()->json(["data"=>$validator->errors(), "success"=> false, "message"=> "valdiation failed"], 422));
    }
}
