<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\NFTController;
use App\Http\Controllers\Api\UserBundleController;
use App\Http\Controllers\Api\UserController;
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

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('bundle', BundleController::class);
    Route::apiResource('nft', NFTController::class);
    Route::apiResource('user-bundle', UserBundleController::class);
});
