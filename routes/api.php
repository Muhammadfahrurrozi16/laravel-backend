<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploudController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('uploud/image', [UploudController::class, 'UploudImage'])->middleware('auth:sanctum');
Route::post('uploud/images', [UploudController::class, 'UploudMultipleImage'])->middleware('auth:sanctum');
Route::post('Midtrans/Notification/handling', [CallbackController::class, 'receive']);
Route::post('orders', [OrderController::class, 'Order'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);
Route::apiResource('Products', ProductController::class);
Route::apiResource('Banners', BannerController::class);
Route::post('fcm-token', [AuthController::class, 'updateFcmToken'])
    ->middleware('auth:sanctum');
