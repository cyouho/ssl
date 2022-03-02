<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Add for password | 用于密码加密
use App\Models\UserAccount; // DB opreate | 操作数据库用
use App\Http\Controllers\Utils as ControllerUtils; // Utils class for controller | controller工具类
use Illuminate\Support\Facades\Redis;

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

        // 将session放入redis中 设置生存时间为: 2592000秒 
        $this->setSessionToRedis($userId, $session);

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
                'api_status_code' => 40401,
            ];
            return response()->json($message, 404);
        } else if (!$userAccount->checkUserPassword($userData, $postData['password'])) {
            $message = [
                'message' => $this->_error_message_api[40402],
                'api_status_code' => 40402,
            ];
            return response()->json($message, 404);
        }

        $loginTime = date('Y-m-d H:i:s');
        $userAccount->updateLastLoginTime($loginTime, $postData['email']); // 更新最后登录时间
        $userAccount->updateUserTotalLoginTimes($postData['email']); // 更新总登录次数
        $userCookie = ControllerUtils::getSessionRandomMD5();
        // 更新用户session
        $userAccount->updataUserSession($postData['email'], $timeData = $userCookie);

        // 将session放入redis中 设置生存时间为: 2592000秒
        $this->setSessionToRedis($userId[0]->user_id, $userCookie);

        $messages = [
            'message' => $this->_success_message_api[20001],
            'session' => $userCookie,
            'api_status_code' => 20001,
        ];

        return response()->json($messages, 200);
    }

    /**
     * Logout function
     * 用户登出
     */
    public function logout(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
        ]);

        $userAccount = new UserAccount();

        $userAccount->deleteUserSession($postData['email'], $deleteData = ['user_session' => NULL]);

        $userId = $userAccount->getUserId($postData['email']);
        $this->deleteSessionFromRedis($userId[0]->user_id);

        $messages = [
            'message' => $this->_success_message_api[20002],
            'api_status_code' => 20002,
        ];

        return response()->json($messages, 200);
    }

    private function setSessionToRedis($userId, $session)
    {
        $redis = Redis::connection('session');
        $redis->setex($userId . '_session', 60 * 60 * 24 * 30, $session);
    }

    private function deleteSessionFromRedis($userId)
    {
        $redis = Redis::connection('session');
        if ($redis->exists($userId . '_session')) {
            $redis->del($userId . '_session');
        }
    }

    // 测试方法，暂时不要删!
    public function testtest(Request $request)
    {
        // $test = new UserAccount();
        // return $test->deleteUserSession($postData = 'sdf@sdf.com', $deleteData = ['user_session' => NULL]);

        //$request->session()->put('test_key', 'testValue');

        $redis = Redis::connection('session');

        if (!$redis->exists('test_key')) {
            $redis->setex('test_key', 60 * 60 * 24 * 30, '4cfee2409b6a137892e7911894a367b8');
        } else {
            $redis->del('test_key');
        }
    }

    public function gettest()
    {
        $redis = Redis::connection('session');
        $value = $redis->get('test_key');
        return response()->json($value, 200);
    }
}
