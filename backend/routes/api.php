<?php

use App\Http\Controllers\Api\TasksController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('tasks')->group(function () {
    Route::post('/create', [TasksController::class, 'create']);
    Route::get('/list/{page}', [TasksController::class, 'list']);
    Route::get('/list', [TasksController::class, 'list']);
    Route::delete('/delete/{id}', [TasksController::class, 'delete']);
    Route::post('/update/{id}', [TasksController::class, 'update']);
});


