<?php

use App\Http\Controllers\Api\TaskController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks', [TaskController::class, 'index']);
Route::post('tasks/update', [TaskController::class, 'update']);
Route::post('tasks/create', [TaskController::class, 'create']);
Route::get('tasks/{task}/{name}', [TaskController::class, 'edit']);
Route::delete('tasks/{task}/delete', [TaskController::class, 'destroy']);
