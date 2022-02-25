<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/test', [AuthController::class, 'testtest']);

// Register user account | 用户注册
Route::post('/register', [
    AuthController::class, 'register'
]);
// Login | 登录
Route::post('/login', [
    AuthController::class, 'login'
]);

// Logout | 登出
Route::post('/logout', [
    AuthController::class, 'logout'
]);









// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
