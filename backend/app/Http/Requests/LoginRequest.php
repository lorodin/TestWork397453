<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Login request
 *
 * @OA\Schema (
 *     @OA\Xml(name="LoginRequest"),
 *     @OA\Property (
 *          property="email",
 *          type="string",
 *          example="user@email.com"
 *     ),
 *     @OA\Property (
 *          property="password",
 *          type="string",
 *          example="password"
 *     )
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email' => 'Email is invalid',
            'password' => 'Password is invalid'
        ];
    }
}
