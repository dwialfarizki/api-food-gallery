<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoodController;

Route::get('/foods', [FoodController::class, 'index']);
Route::post('/foods', [FoodController::class, 'store']);
Route::put('/foods/{id}', [FoodController::class, 'update']);
Route::delete('/foods/{id}', [FoodController::class, 'destroy']);


