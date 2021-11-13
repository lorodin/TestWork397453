<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Update task request
 *
 * @OA\Schema (
 *     @OA\Xml(name="TaskUpdateRequest"),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="task 1"
 *     ),
 *     @OA\Property (
 *          property="description",
 *          type="string",
 *          example="description"
 *     ),
 *     @OA\Property (
 *          property="completed",
 *          type="bool",
 *          example="1"
 *     )
 * )
 */
class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "string|required",
            "description" => "string|required",
            "completed" => "bool|required"
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
