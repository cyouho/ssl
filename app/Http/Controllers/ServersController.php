<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servers;

/**
 * User Servers Class.
 * 用户服务类
 */
class ServersController extends Controller
{
    public function getAllServers()
    {
        $servers = new Servers();
        $allServers = $servers->getAllServers(
            $columnName = ['server_id', 'server_name'],
            $condition = []
        );

        return response()->json($allServers, 200);
    }
}
