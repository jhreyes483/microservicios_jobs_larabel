<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/farmers-market/buy', [IngredientController::class, 'buy']);
    Route::post('/farmers-market/get', [IngredientController::class, 'get']);
    Route::post('/farmers-market/update', [IngredientController::class, 'update']);
});
