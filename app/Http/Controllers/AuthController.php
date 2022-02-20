<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Add for password | 用于密码加密
use App\Models\UserAccount; // DB opreate | 操作数据库用
use App\Http\Controllers\Utils as ControllerUtils; // Utils class for controller | controller工具类

/**
 * Authenticate for users. 
 * 用户验证类
 */
class AuthController extends Controller
{
    /**
     * Register function
     * 用户注册
     * 
     * @param Request $request <form data | form数据>
     */
    public function register(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email|unique:user_accounts,user_email',
            'password' => 'required|min:8|max:16'
        ]);

        $userAccount = new UserAccount();

        $userName = ControllerUtils::getNameFromEmail($postData['email']);
        $timestamp = time();
        $session = ControllerUtils::getSessionRandomMD5();
        $password = Hash::make($postData['password']);
        $data = [
            'user_name'     => $userName,
            'user_email'    => $postData['email'],
            'user_password' => $password,
            'user_session'  => $session,
            'create_at'     => $timestamp,
            'update_at'     => $timestamp,
            'total_login_times' => 1,
        ];

        $userAccount->insertUserData($data);

        return response()->json($postData, 201);
    }

    /**
     * Login function
     * 用户登录
     */
    public function login(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email|unique:user_accounts,user_email',
            'password' => 'required|min:8|max:16'
        ]);

        $userAccount = new UserAccount();
    }

    /**
     * Logout function
     * 用户登出
     */
    public function logout()
    {
    }
}
