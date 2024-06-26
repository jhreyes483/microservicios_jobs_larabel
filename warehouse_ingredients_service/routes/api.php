<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Ingredient\IngredientController;
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
    Route::post('/get_ingredients', [IngredientController::class, 'index']);
    Route::post('/get_complements', [IngredientController::class, 'getComplements']);
    Route::post('/ingredints_mass', [IngredientController::class, 'getIngredientsMass']);
    Route::post('/get_purchase', [IngredientController::class, 'purchaseIndex']);
});
