<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserServers;

class UserController extends Controller
{
    private array $_server_name = [];

    private array $_server_status = [];

    public function __construct()
    {
        $this->_server_name = config('userservers.server_name');
        $this->_server_status = config('userservers.status');
    }

    public function getUserServers(Request $request, int $userId)
    {
        $userServer = new UserServers();

        $result = $userServer->getUserServers(
            $columnName = ['server_id'],
            $condition = [['user_id', $userId]]
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

        $id = $userServer->setUserServers($insertData = [
            'server_id' => $postData['server_id'],
            'user_id' => $postData['user_id'],
            'server_name' => '',
            'server_status' => 1,
            'created_at' => '',
            'updated_at' => '',
        ]);
    }
}
