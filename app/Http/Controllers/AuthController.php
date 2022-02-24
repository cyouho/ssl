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
    private $_success_message_api = [];

    private $_error_message_api = [];

    /**
     * Init the auth controller.
     * Get message for user authentication.
     * 初始化api的message。
     */
    public function __construct()
    {
        $this->_success_message_api = config('message.success_message.api');
        $this->_error_message_api = config('message.error_message.api');
    }

    /**
     * Register function
     * 用户注册
     * 
     * @param Request $request <form data | form数据>
     * 
     * @return json $responseMessage $statusCode
     */
    public function register(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email|unique:user_accounts,user_email',
            'password' => 'required|min:8|max:16'
        ]);

        $userAccount = new UserAccount();

        $userName = ControllerUtils::getNameFromEmail($postData['email']);
        $timestamp = date("Y-m-d H:i:s"); // @todo 需要斟酌！！！
        $session = ControllerUtils::getSessionRandomMD5();
        $password = Hash::make($postData['password']);
        $data = [
            'user_name'     => $userName,
            'user_email'    => $postData['email'],
            'user_password' => $password,
            'user_session'  => $session,
            'created_at'     => $timestamp,
            'updated_at'     => $timestamp,
            'last_login_at' => $timestamp,
            'total_login_times' => 1,
        ];

        // Insert user data into database. | 插入注册用户信息
        $userId = $userAccount->insertUserData($data);

        if ($userId) {
            $responseMessage = [
                'message' => $this->_success_message_api[201],
                'session' => $session,
            ];
            $statusCode = 201;
        } else {
            $responseMessage = [
                'message' => $this->_error_message_api[404],
            ];
            $statusCode = 404;
        }

        return response()->json($responseMessage, $statusCode);
    }

    /**
     * Login function
     * 用户登录
     */
    public function login(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:16'
        ]);

        $userAccount = new UserAccount();
        $userId = $userAccount->getUserId($postData['email']);
        $userData = [
            'user_email' => $postData['email'],
        ];

        // if for user exist and else if for password correct.
        if (!$userId) {
            $message = [
                'message' => $this->_error_message_api[40401],
                'status_code' => 40401,
            ];
            return response()->json($message, 404);
        } else if (!$userAccount->checkUserPassword($userData, $postData['password'])) {
            $message = [
                'message' => $this->_error_message_api[40402],
                'status_code' => 40402,
            ];
            return response()->json($message, 404);
        }

        $loginTime = date('Y-m-d H:i:s');
        $userAccount->updateLastLoginTime($loginTime, $postData['email']); // 更新最后登录时间
        $userAccount->updateUserTotalLoginTimes($postData['email']); // 更新总登录次数
        $userAccount->updataUserSession($postData['email'], $timeData = ControllerUtils::getSessionRandomMD5()); // 更新用户session

        $userCookie = $userAccount->getUserCookie($postData['email']);

        return response()->json($userCookie, 200);
    }

    /**
     * Logout function
     * 用户登出
     */
    public function logout()
    {
    }

    // 测试方法，暂时不要删!
    // public function testtest()
    // {
    //     $test = new UserAccount();
    //     return $test->updataUserSession($postData = 'sdf@sdf.com', $session = ControllerUtils::getSessionRandomMD5());
    // }
}
