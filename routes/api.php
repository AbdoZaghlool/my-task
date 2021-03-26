<?php

use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\MainController;
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



Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('register', [AuthUserController::class,'register']);
    Route::post('login', [AuthUserController::class,'login']);

    
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('projects', [MainController::class,'projects']);
    });
});