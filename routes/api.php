<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('todo')->group(function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::post('/create', [TodoController::class, 'create']);
    Route::get('/show', [TodoController::class, 'show']);
    Route::post('/update', [TodoController::class, 'update']);
    Route::post('/destroy', [TodoController::class, 'destroy']);
});
