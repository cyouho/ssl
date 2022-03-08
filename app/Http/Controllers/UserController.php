<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserServers;

class UserController extends Controller
{
    public function getUserServers(Request $request)
    {
        $postData = $request->validate([
            'user_id' => 'required|integer',
            'server_id' => 'required|integer',
        ]);

        $userServer = new UserServers();
    }

    public function setUserServers(Request $request)
    {
        $postData = $request->validate([
            'user_id' => 'required|integer',
            'server_id' => 'required|integer',
        ]);

        $userServer = new UserServers();
    }
}
