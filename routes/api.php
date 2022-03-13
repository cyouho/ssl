<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

/* test Route */

Route::get('/test', [AuthController::class, 'testtest']);
Route::get('/get', [AuthController::class, 'gettest']);
Route::get('/set', [AuthController::class, 'settest']);

// Register user account | 用户注册
Route::post('/register', [AuthController::class, 'register']);
// Login | 登录
Route::post('/login', [AuthController::class, 'login']);
// Logout | 登出
Route::post('/logout', [AuthController::class, 'logout']);
// authenticate | 登录状态确认
Route::post('/authenticate', [AuthController::class, 'authenticate']);
// version 1 get user servers | v1 版本获取用户注册服务信息
Route::get('/v1/user/servers/{userId}', [UserController::class, 'getUserServers'])->whereNumber('userId');
// version 1 set user servers | v1 版本设置用户注册服务信息
Route::post('/v1/user/servers', [UserController::class, 'setUserServers']);
// version 1 update user servers status | v1 版本更改用户注册服务状态
Route::put('/v1/user/servers/status/{userId}', [UserController::class, 'changeUserServerStatus'])->whereNumber('userId');

Route::get('/v1', function () {
    $URLs = config('apiurls.api_urls');
    return response()->json($URLs, 200);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
