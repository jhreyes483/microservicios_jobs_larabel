<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RecipeController;


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

Route::get('/images/{filename}', [OrderController::class, 'getImage']);
Route::apiResource('orders', OrderController::class)->only([ 'store', 'show'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/get_orders', [OrderController::class, 'index']);
    Route::post('/recipe', [RecipeController::class, 'index']);
    Route::post('/get_status', [OrderController::class, 'getStatus']);
    Route::post('/recipe/get_complements', [RecipeController::class, 'getComplements']);
    Route::post('/job/receive_ingredient', [OrderController::class, 'receiveIngredient']);
});


