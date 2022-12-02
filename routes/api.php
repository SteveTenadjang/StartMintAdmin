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
Route::post('forgot-password', [AuthController::class,'forgotPassword']);
Route::post('reset-password', [AuthController::class,'resetPassword']);

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::apiResource('bundle', BundleController::class);
    Route::apiResource('nft', NFTController::class);
    Route::apiResource('user-bundle', UserBundleController::class);
    Route::get('user',[UserController::class,'show']);
    Route::post('user',[UserController::class,'store']);
    Route::put('user',[UserController::class,'update']);
    Route::delete('user',[UserController::class,'delete']);
    Route::get('users',[UserController::class,'index']);
//    Route::apiResource('user', UserController::class)->only('index','store','delete');
//    Route::group(['middleware' => 'verified'], static function () {
//    });
//    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->name('verification.notice');
//    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});
