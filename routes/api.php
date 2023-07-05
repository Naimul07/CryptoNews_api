<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::group(['middleware'=>('auth:api')], function () {
// // Route::get('/posts',[PostController::class,'show']);
    
// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/posts',[PostController::class,'show']); 
    Route::post('/logout',[AuthController::class,'logout']);  
});
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

