<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task model
 *
 * @OA\Schema (
 *     @OA\Xml(name="Task"),
 *     @OA\Property (
 *         property="id",
 *         type="int",
 *         example="1"
 *     ),
 *     @OA\Property (
 *         property="name",
 *         type="string",
 *         example="task 1"
 *     ),
 *     @OA\Property (
 *         property="description",
 *         type="string",
 *         example="description 1"
 *     ),
 *     @OA\Property (
 *         property="completed",
 *         type="bool",
 *         example="true"
 *      )
 * )
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property boolean $completed
 */
class Task extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'name',
        'description',
        'completed'
    ];

    protected $casts = [
        'completed' => 'bool'
    ];
}
