<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\UserServers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * Get User Data Class.
 * 获取用户数据类
 */
class UserController extends Controller
{
    private array $_server_name = [];

    private array $_server_status = [];

    private array $_server_error_messages = [];

    private array $_server_success_messages = [];

    public function __construct()
    {
        $this->_server_name = config('userservers.server_name');
        $this->_server_status = config('userservers.status');
        $this->_server_error_messages = config('message.error_message.api');
        $this->_server_success_messages = config('message.success_message.api');
    }

    /**
     * Get User Servers.
     * 获取用户已注册的服务
     * 
     * @param Request $request <IO datas | 输入数据>
     * @param int $userId <user id | 用户Id>
     * 
     * @return response
     */
    public function getUserServers(Request $request, int $userId)
    {
        $userServer = new UserServers();

        $result = $userServer->getUserServers(
            $columnName = ['*'],
            $condition = [['user_id', $userId]]
        );

        return response()->json($result, 200);
    }

    public function getUserData(Request $request, int $userId)
    {
        $userData = new UserAccount();

        $result = $userData->getUserDataForProfile(
            $columnName = ['*'],
            $conditions = [
                ['user_id', $userId],
            ]
        );

        return response()->json($result, 200);
    }

    public function setUserServers(Request $request)
    {
        $postData = $request->validate([
            'user_id' => 'required|integer',
            'server_id' => 'required|integer',
        ]);

        $userServer = new UserServers();

        $result = $userServer->ifExistServerForTheUser(
            $columnName = ['server_id'],
            $condition = [['user_id', $postData['user_id']]]
        );

        if ($result) {
            $message = [
                'message' => $this->_server_error_messages[40404],
                'api_status_code' => 40404,
            ];
            $httpStatus = 400;
        } else {
            $timestamp = date("Y-m-d H:i:s");

            $id = $userServer->setUserServers($insertData = [
                'server_id' => $postData['server_id'],
                'user_id' => $postData['user_id'],
                'server_name' => $this->_server_name[$postData['server_id']],
                'server_status' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            $message = [
                'message' => $this->_server_success_messages[20003],
                'api_status_code' => 20003,
            ];
            $httpStatus = 201;
        }
        return response()->json($message, $httpStatus);
    }

    public function changeUserServerStatus(Request $request, int $userId)
    {
        $postData = $request->validate([
            'server_id' => 'required|integer',
        ]);

        $userServer = new UserServers();

        $result = $userServer->setUserServersStatus(
            $condition = [
                ['user_id', $userId],
                ['server_id', $postData['server_id']],
            ],
            $updateData = [
                'server_status' => DB::raw('IF (server_status = 1, 0, 1)'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        if ($result) {
            $message = [
                'message' => $this->_server_success_messages[20004],
                'api_status_code' => 20004,
            ];
            $httpStatus = 200;
        } else {
            $message = [
                'message' => $this->_server_error_messages[40405],
                'api_status_code' => 40405,
            ];
            $httpStatus = 400;
        }

        return response()->json($message, $httpStatus);
    }

    public function changeUserName(Request $request, int $userId)
    {
        $postData = $request->validate([
            'user_name' => 'required',
            'user_session' => 'required',
        ]);

        $user = new UserAccount();
        $user->changeUserName(
            $condition = [['user_id', $userId]],
            $updateData = [
                'user_name' => $postData['user_name'],
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );

        $userSession = $postData['user_session'];
        // 修改Redis中的用户名
        $this->changeUserNameFromRedis($userSession, $postData['user_name']);

        $messages = [
            'message' => $this->_server_success_messages[20005],
            'api_status_code' => 20005,
        ];
        $httpStatus = 201;

        return response()->json($messages, $httpStatus);
    }

    private function changeUserNameFromRedis($userSession, $userName)
    {
        $redis = Redis::connection('session');

        $redis->hmset($userSession, [
            'user_name' => $userName,
        ]);
    }
}
