<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Create task request
 *
 * @OA\Schema (
 *     @OA\Xml(name="TaskCreateRequest"),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="task 1"
 *     ),
 *     @OA\Property (
 *          property="description",
 *          type="string",
 *          example="description"
 *     )
 * )
 */
class TaskCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "string|required",
            "description" => "string|required"
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Task name is required',
            'description.required' => 'Task description is required'
        ];
    }
}
