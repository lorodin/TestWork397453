<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::prefix('tasks')->middleware('auth:api')->group(function () {
    Route::post('/create', [TasksController::class, 'create']);
    Route::get('/list/{page}', [TasksController::class, 'list']);
    Route::get('/list', [TasksController::class, 'list']);
    Route::delete('/delete/{id}', [TasksController::class, 'delete']);
    Route::post('/update/{id}', [TasksController::class, 'update']);
});


