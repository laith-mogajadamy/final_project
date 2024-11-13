<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/allusers', [UsersController::class, 'index'])
                ->middleware(['auth:sanctum'])
                ->name('allusers');

Route::middleware(['auth:sanctum'])->group(function () {
       Route::apiResource('food-items', FoodItemController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('meals', MealController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('order', OrderController::class);
});
