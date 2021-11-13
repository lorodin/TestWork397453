<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirm' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Name is invalid',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exist',
            'password.required' => 'Password is required',
            'password.min' => 'Min password length is 5 chars',
            'confirm.required' => 'Please confirm password',
            'confirm.same' => 'Password is not confirmed'
        ];
    }
}
